<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with(['items.product', 'branch', 'address'])
            ->where('customer_id', auth()->id())
            ->latest()
            ->get();

        return view('customer.orders', compact('orders'));
    }

    public function requestCancellation(Order $order): RedirectResponse
    {
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($order->status, ['pending', 'shipped'])) {
            return back()->with('error', 'Cancellation can only be requested for pending or shipped orders.');
        }

        if ($order->cancellation_requested) {
            return back()->with('error', 'Cancellation already requested.');
        }

        $order->update([
            'cancellation_requested' => true,
            'cancellation_status'    => 'pending',
        ]);

        return back()->with('success', 'Cancellation request submitted.');
    }
}
