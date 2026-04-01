<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\PriceChangeRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PriceChangeRequestController extends Controller
{
    public function index(): View
    {
        $requests = PriceChangeRequest::with('product.subcategory.category')
            ->where('branch_id', auth()->user()->branch_id)
            ->latest()
            ->paginate(10);

        return view('branch.price-requests.index', compact('requests'));
    }

    public function create(): View
    {
        $products = Product::with('subcategory.category')->orderBy('name')->get();

        return view('branch.price-requests.create', compact('products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id'      => ['required', 'exists:products,id'],
            'requested_price' => ['required', 'numeric', 'min:0'],
            'reason'          => ['required', 'string', 'max:1000'],
        ]);

        $alreadyPending = PriceChangeRequest::where('branch_id', auth()->user()->branch_id)
            ->where('product_id', $validated['product_id'])
            ->where('status', 'pending')
            ->exists();

        if ($alreadyPending) {
            return back()->withErrors([
                'product_id' => 'You already have a pending request for this product.',
            ])->withInput();
        }

        $product = Product::findOrFail($validated['product_id']);

        PriceChangeRequest::create([
            'branch_id'       => auth()->user()->branch_id,
            'product_id'      => $validated['product_id'],
            'current_price'   => $product->price,
            'requested_price' => $validated['requested_price'],
            'reason'          => $validated['reason'],
            'status'          => 'pending',
        ]);

        return redirect()->route('branch.price-requests.index')
            ->with('success', 'Price change request submitted.');
    }
}
