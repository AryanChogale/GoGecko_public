<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Get the logged-in customer's assigned branch ID.
     */
    private function getCustomerBranchId(): ?int
    {
        if (!Auth::check() || !Auth::user()->isCustomer()) {
            return null;
        }

        $profile = DB::table('customer_profiles')
            ->where('user_id', Auth::id())
            ->first();

        return $profile?->selected_branch_id;
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['nullable', 'integer', 'min:1'],
        ]);

        $productId = $request->product_id;
        $quantity  = $request->quantity ?? 1;

        if (Auth::check() && Auth::user()->isCustomer()) {

            $item = CartItem::where('customer_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($item) {
                $item->increment('quantity', $quantity);
            } else {
                CartItem::create([
                    'customer_id' => Auth::id(),
                    'product_id'  => $productId,
                    'quantity'    => $quantity,
                ]);
            }

        } else {

            $cart = session()->get('guest_cart', []);

            if (isset($cart[$productId])) {
                $cart[$productId] += $quantity;
            } else {
                $cart[$productId] = $quantity;
            }

            session()->put('guest_cart', $cart);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Added to cart.');
    }

    public function merge(): void
    {
        $cart = session()->get('guest_cart', []);

        if (empty($cart) || !Auth::user()?->isCustomer()) {
            return;
        }

        foreach ($cart as $productId => $quantity) {

            $item = CartItem::where('customer_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($item) {
                $item->increment('quantity', $quantity);
            } else {
                CartItem::create([
                    'customer_id' => Auth::id(),
                    'product_id'  => $productId,
                    'quantity'    => $quantity,
                ]);
            }
        }

        session()->forget('guest_cart');
    }

    public function index(): View
    {
        $branchId = $this->getCustomerBranchId();

        if (Auth::check() && Auth::user()->isCustomer()) {

            $cartItems = CartItem::with('product')
                ->where('customer_id', Auth::id())
                ->get();

        } else {

            $guestCart = session()->get('guest_cart', []);
            $cartItems = collect();

            if (!empty($guestCart)) {
                $products = Product::whereIn('id', array_keys($guestCart))->get();

                foreach ($products as $product) {
                    $cartItems->push((object)[
                        'product'  => $product,
                        'quantity' => $guestCart[$product->id],
                    ]);
                }
            }
        }

        $states    = Branch::distinct()->orderBy('name')->pluck('name');
        $addresses = (Auth::check() && Auth::user()->isCustomer())
            ? Auth::user()->addresses()->latest()->get()
            : collect();

        return view('cart.index', compact('cartItems', 'addresses', 'states', 'branchId'));
    }

    public function updateQuantity(Request $request)
    {
        $productId = $request->product_id;
        $change    = $request->change;
        $branchId  = $this->getCustomerBranchId();

        if (Auth::check() && Auth::user()->isCustomer()) {

            $item = CartItem::where('customer_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if (!$item) return response()->json([]);

            $item->quantity += $change;

            if ($item->quantity <= 0) {
                $item->delete();
                return response()->json([
                    'removed'    => true,
                    'removedQty' => abs($change),
                ]);
            }

            $item->save();

            $unitPrice = $item->product->priceForBranch($branchId);

            $cartTotal = CartItem::where('customer_id', Auth::id())
                ->with('product')
                ->get()
                ->sum(fn($i) => $i->product->priceForBranch($branchId) * $i->quantity);

            return response()->json([
                'quantity'  => $item->quantity,
                'total'     => number_format($unitPrice * $item->quantity, 2),
                'cartTotal' => number_format($cartTotal, 2),
            ]);
        }

        // Guest cart - no branch, use global price
        $cart = session()->get('guest_cart', []);

        if (!isset($cart[$productId])) return response()->json([]);

        $cart[$productId] += $change;

        if ($cart[$productId] <= 0) {
            unset($cart[$productId]);
            session()->put('guest_cart', $cart);
            return response()->json(['removed' => true, 'removedQty' => abs($change)]);
        }

        session()->put('guest_cart', $cart);

        $product   = Product::find($productId);
        $unitPrice = $product->priceForBranch(null);

        $cartTotal = collect($cart)->map(function ($qty, $pid) {
            $p = Product::find($pid);
            return $p ? $p->priceForBranch(null) * $qty : 0;
        })->sum();

        return response()->json([
            'quantity'  => $cart[$productId],
            'total'     => number_format($unitPrice * $cart[$productId], 2),
            'cartTotal' => number_format($cartTotal, 2),
        ]);
    }
}
