<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $branchId = auth()->user()->branch_id;

        $orders = Order::with(['items.product', 'customer', 'address'])
            ->where('branch_id', $branchId)
            ->latest()
            ->get();

        return view('branch.orders', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        if ($order->branch_id !== auth()->user()->branch_id) {
            abort(403);
        }

        $request->validate([
            'status' => ['required', 'in:pending,shipped,out_for_delivery,delivered'],
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated.');
    }

    public function approveCancellation(Order $order): RedirectResponse
    {
        if ($order->branch_id !== auth()->user()->branch_id) {
            abort(403);
        }

        $order->update(['cancellation_status' => 'approved']);

        return back()->with('success', 'Cancellation approved.');
    }

    public function rejectCancellation(Order $order): RedirectResponse
    {
        if ($order->branch_id !== auth()->user()->branch_id) {
            abort(403);
        }

        $order->update(['cancellation_status' => 'rejected']);

        return back()->with('success', 'Cancellation rejected.');
    }
}
