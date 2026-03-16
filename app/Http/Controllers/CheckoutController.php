<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use App\Models\Address;
use App\Models\Branch;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function selectAddress(Request $request): RedirectResponse
    {
        $request->validate([
            'address_id' => ['required', 'exists:addresses,id'],
        ]);

        if ($request->has('sms_consent')) {
            auth()->user()->update(['sms_consent' => true]);
        }

        $address = Address::findOrFail($request->address_id);

        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        // Get branch from customer_profiles (assigned at registration)
        $profile  = DB::table('customer_profiles')
            ->where('user_id', auth()->id())
            ->first();

        $branchId = $profile?->selected_branch_id;

        // Fallback: if no branch assigned yet, geocode and assign now
        if (!$branchId) {
            $user  = auth()->user();
            $state = $user->state ?? $address->state;
            $city  = $user->city  ?? $address->city;

            $branches = Branch::where('name', $state)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get();

            if ($branches->isEmpty()) {
                return back()->with('error', 'No branches available in your state yet.');
            }

            $coords = app(\App\Services\GeoService::class)->geocode($city, $state);

            if (!$coords) {
                return back()->with('error', 'Could not locate your city. Please try a different address.');
            }

            $closest  = app(\App\Services\GeoService::class)->closestBranch($branches, $coords['lat'], $coords['lng']);
            $branchId = $closest?->id;

            // Save for future orders
            if ($branchId) {
                DB::table('customer_profiles')
                    ->where('user_id', auth()->id())
                    ->update([
                        'selected_branch_id' => $branchId,
                        'lat'                => $coords['lat'],
                        'lng'                => $coords['lng'],
                        'updated_at'         => now(),
                    ]);
            }
        }

        if (!$branchId) {
            return back()->with('error', 'Could not determine nearest branch. Please try again.');
        }

        $branch    = Branch::findOrFail($branchId);
        $cartItems = CartItem::with('product')
            ->where('customer_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Use branch-specific price for each product
        $total = $cartItems->sum(
            fn($item) => $item->product->priceForBranch($branchId) * $item->quantity
        );

        $order = Order::create([
            'customer_id'  => auth()->id(),
            'branch_id'    => $branchId,
            'address_id'   => $address->id,
            'total_amount' => $total,
            'status'       => 'pending',
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'          => $order->id,
                'product_id'        => $item->product_id,
                'quantity'          => $item->quantity,
                'price_at_purchase' => $item->product->priceForBranch($branchId),
            ]);
        }

        CartItem::where('customer_id', auth()->id())->delete();

        app(NotificationService::class)->sendOrderConfirmation($order);

        return redirect()->route('customer.orders')
            ->with('success', 'Order placed! Assigned to our ' . $branch->name . ' — ' . $branch->city . ' branch. Order #' . $order->id);
    }
}