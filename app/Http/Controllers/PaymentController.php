<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\SquareService;
use App\Services\NotificationService;
use App\Models\CartItem;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        protected SquareService $square,
        protected NotificationService $notifications,
    ) {}

    /**
     * Show the checkout page with Square card form.
     */
    public function checkout(Order $order)
    {
        abort_if($order->customer_id !== auth()->id(), 403);

        // Already paid - send straight to orders
        if ($order->payment_status === 'paid') {
            return redirect()->route('customer.orders')
                ->with('success', 'Order #' . $order->id . ' already paid!');
        }

        $order->load(['branch', 'address', 'items.product']);

        return view('payment.checkout', [
            'order'      => $order,
            'appId'      => config('square.app_id'),
            'locationId' => config('square.location_id'),
        ]);
    }

    /**
     * Process payment - called via AJAX from checkout page.
     */
    public function process(Request $request, Order $order)
    {
        abort_if($order->customer_id !== auth()->id(), 403);

        $request->validate([
            'source_id' => ['required', 'string'],
        ]);

        $result = $this->square->charge(
            $request->source_id,
            $order->total_amount,
            $order->id,
        );

        if ($result['success']) {
            $order->update([
                'square_payment_id' => $result['payment_id'],
                'payment_status'    => 'paid',
            ]);

            // Clear cart now that payment confirmed
            CartItem::where('customer_id', auth()->id())->delete();

            // Fire Twilio SMS + WhatsApp
            $this->notifications->sendOrderConfirmation($order);

            return response()->json([
                'success'  => true,
                'redirect' => route('customer.orders'),
                'message'  => 'Order #' . $order->id . ' confirmed! You\'ll receive an SMS shortly.',
            ]);
        }

        $order->update(['payment_status' => 'failed']);

        return response()->json([
            'success' => false,
            'error'   => $result['error'] ?? 'Payment failed. Please try again.',
        ], 422);
    }
}
