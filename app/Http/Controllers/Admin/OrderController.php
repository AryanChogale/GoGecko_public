<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with(['items.product', 'customer', 'branch', 'address'])
            ->latest()
            ->get();

        return view('admin.orders', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:pending,shipped,out_for_delivery,delivered'],
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated.');
    }

    public function approveCancellation(Order $order): RedirectResponse
    {
        $order->update(['cancellation_status' => 'approved']);

        return back()->with('success', 'Cancellation approved.');
    }

    public function rejectCancellation(Order $order): RedirectResponse
    {
        $order->update(['cancellation_status' => 'rejected']);

        return back()->with('success', 'Cancellation rejected.');
    }
}
