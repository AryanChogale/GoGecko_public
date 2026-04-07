<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $show = request('show');

        $orders = Order::with(['items.product', 'customer', 'branch', 'address'])
            ->when($show === 'unassigned', fn ($query) => $query->whereNull('branch_id'))
            ->latest()
            ->get();

        $branches = Branch::query()
            ->orderBy('name')
            ->orderBy('city')
            ->get(['id', 'name', 'city']);

        return view('admin.orders', compact('orders', 'branches', 'show'));
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

    public function assignBranch(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'branch_id' => ['required', 'exists:branches,id'],
        ]);

        $order->update([
            'branch_id' => $request->integer('branch_id'),
        ]);

        return back()->with('success', 'Branch assigned successfully.');
    }
}
