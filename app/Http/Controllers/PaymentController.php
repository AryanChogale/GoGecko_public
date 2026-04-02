<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\SquareService;
use App\Services\NotificationService;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Already paid — send straight to orders
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
     * Process payment — called via AJAX from checkout page.
     */
    public function process(Request $request, Order $order)
    {
        abort_if($order->customer_id !== auth()->id(), 403);

        if ($order->payment_status === 'paid') {
            return response()->json([
                'success'  => true,
                'redirect' => route('customer.orders'),
                'message'  => 'Order #' . $order->id . ' is already paid.',
            ]);
        }

        $request->validate([
            'source_id' => ['required', 'string'],
        ]);

        $result = ['success' => false];

        try {
            DB::transaction(function () use ($request, $order, &$result) {
                $lockedOrder = Order::query()
                    ->whereKey($order->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($lockedOrder->payment_status === 'paid') {
                    $result = ['already_paid' => true];
                    return;
                }

                $lockedOrder->load('items');

                foreach ($lockedOrder->items as $item) {
                    $product = Product::query()
                        ->whereKey($item->product_id)
                        ->lockForUpdate()
                        ->first();

                    if (!$product) {
                        throw new \RuntimeException('One of the products in your order is no longer available.');
                    }

                    if ($product->quantity < $item->quantity) {
                        throw new \RuntimeException('Not enough stock available for ' . $product->name . '. Please update your cart and try again.');
                    }
                }

                $result = $this->square->charge(
                    $request->source_id,
                    $lockedOrder->total_amount,
                    $lockedOrder->id,
                );

                if (!$result['success']) {
                    $lockedOrder->update(['payment_status' => 'failed']);
                    return;
                }

                foreach ($lockedOrder->items as $item) {
                    Product::query()
                        ->whereKey($item->product_id)
                        ->decrement('quantity', $item->quantity);
                }

                $lockedOrder->update([
                    'square_payment_id' => $result['payment_id'],
                    'payment_status'    => 'paid',
                ]);
            });
        } catch (\RuntimeException $exception) {
            return response()->json([
                'success' => false,
                'error'   => $exception->getMessage(),
            ], 422);
        }

        if (($result['already_paid'] ?? false) === true) {
            return response()->json([
                'success'  => true,
                'redirect' => route('customer.orders'),
                'message'  => 'Order #' . $order->id . ' is already paid.',
            ]);
        }

        if ($result['success']) {
            CartItem::where('customer_id', auth()->id())->delete();
            $this->notifications->sendOrderConfirmation($order->fresh(['items.product', 'customer.customerProfile']));

            return response()->json([
                'success'  => true,
                'redirect' => route('customer.orders'),
                'message'  => 'Order #' . $order->id . ' confirmed! You\'ll receive an SMS shortly.',
            ]);
        }

        return response()->json([
            'success' => false,
            'error'   => $result['error'] ?? 'Payment failed. Please try again.',
        ], 422);
    }
}
