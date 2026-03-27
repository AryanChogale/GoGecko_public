<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BranchProductPrice;
use App\Models\PriceChangeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PriceChangeRequestController extends Controller
{
    public function index(): View
    {
        $requests = PriceChangeRequest::with(['branch', 'product'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.price-requests.index', compact('requests'));
    }

    public function history(): View
    {
        $requests = PriceChangeRequest::with(['branch', 'product', 'reviewer'])
            ->whereIn('status', ['approved', 'rejected'])
            ->latest()
            ->paginate(10);

        return view('admin.price-requests.history', compact('requests'));
    }

    public function approve(Request $request, PriceChangeRequest $priceChangeRequest): RedirectResponse
    {
        $validated = $request->validate([
            'final_price' => ['required', 'numeric', 'min:0'],
        ]);

        // Write to branch_product_prices - does NOT touch products.price
        BranchProductPrice::updateOrCreate(
            [
                'branch_id'  => $priceChangeRequest->branch_id,
                'product_id' => $priceChangeRequest->product_id,
            ],
            ['price' => $validated['final_price']]
        );

        $priceChangeRequest->update([
            'status'      => 'approved',
            'final_price' => $validated['final_price'],
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()->route('admin.price-requests.index')
            ->with('success', 'Price change approved for ' . $priceChangeRequest->branch->name . ' branch.');
    }

    public function reject(PriceChangeRequest $priceChangeRequest): RedirectResponse
    {
        $priceChangeRequest->update([
            'status'      => 'rejected',
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()->route('admin.price-requests.index')
            ->with('success', 'Price change request rejected.');
    }

    /**
     * Revert a branch's price override back to the global base price.
     * Deletes the row from branch_product_prices so priceForBranch() falls back to products.price.
     */
    public function revert(PriceChangeRequest $priceChangeRequest): RedirectResponse
    {
        BranchProductPrice::where('branch_id', $priceChangeRequest->branch_id)
            ->where('product_id', $priceChangeRequest->product_id)
            ->delete();

        return redirect()->route('admin.price-requests.history')
            ->with('success', $priceChangeRequest->branch->name . ' price for "' . $priceChangeRequest->product->name . '" reverted to base price.');
    }

    /**
     * Directly modify the branch-specific price without a new request.
     */
    public function modifyPrice(Request $request, PriceChangeRequest $priceChangeRequest): RedirectResponse
    {
        $validated = $request->validate([
            'new_price' => ['required', 'numeric', 'min:0'],
        ]);

        BranchProductPrice::updateOrCreate(
            [
                'branch_id'  => $priceChangeRequest->branch_id,
                'product_id' => $priceChangeRequest->product_id,
            ],
            ['price' => $validated['new_price']]
        );

        // Also update the history record's final_price so history stays accurate
        $priceChangeRequest->update(['final_price' => $validated['new_price']]);

        return redirect()->route('admin.price-requests.history')
            ->with('success', $priceChangeRequest->branch->name . ' price for "' . $priceChangeRequest->product->name . '" updated to ₹' . number_format($validated['new_price'], 2) . '.');
    }
}
