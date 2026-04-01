<?php

namespace App\Services;

use App\Models\NotificationsLog;
use App\Models\Order;
use Twilio\Rest\Client;
use Throwable;

class NotificationService
{
    protected Client $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    public function sendOrderConfirmation(Order $order): void
    {
        $order->load(['customer', 'branch', 'address', 'items.product']);

        $address = $order->address;

        if (!$address) {
            return;
        }

        // Check user consent
        $customer = $order->customer;
        if ($customer->customerProfile->sms_consent) {
            return;
        }

        $variables = json_encode([
            '1' => (string) $order->id,
            '2' => number_format($order->total_amount, 2),
            '3' => $order->branch->name . ' — ' . $order->branch->city,
            '4' => $address->name,
        ]);

        // Send WhatsApp
        $this->sendWhatsApp($order, $address->whatsapp, $variables);

        // Send SMS
        $this->sendSms($order, $address->phone, $order);
    }

    protected function sendWhatsApp(Order $order, string $to, string $variables): void
    {
        $to = $this->formatPhone($to);

        try {
            $this->twilio->messages->create(
                'whatsapp:' . $to,
                [
                    'from'              => config('services.twilio.whatsapp_from'),
                    'contentSid'        => config('services.twilio.template_sid'),
                    'contentVariables'  => $variables,
                ]
            );

            $this->log($order, 'whatsapp', 'sent');
        } catch (Throwable $e) {
            $this->log($order, 'whatsapp', 'failed');
        }
    }

    protected function sendSms(Order $order, string $to, Order $orderData): void
    {
        $to = $this->formatPhone($to);

        $message = "Your GoGecko order #{$order->id} has been confirmed!"
            . " Total: Rs." . number_format($order->total_amount, 2)
            . ". Branch: {$order->branch->name} — {$order->branch->city}."
            . " We will deliver to {$order->address->name} soon.";

        try {
            $this->twilio->messages->create(
                $to,
                [
                    'from' => config('services.twilio.sms_from'),
                    'body' => $message,
                ]
            );

            $this->log($order, 'sms', 'sent');
        } catch (Throwable $e) {
            $this->log($order, 'sms', 'failed');
        }
    }

    protected function formatPhone(string $phone): string
    {
        // Strip spaces and dashes
        $phone = preg_replace('/[\s\-]/', '', $phone);

        // Add India country code if not present
        if (!str_starts_with($phone, '+')) {
            $phone = '+91' . ltrim($phone, '0');
        }

        return $phone;
    }

    protected function log(Order $order, string $channel, string $status): void
    {
        NotificationsLog::create([
            'user_id'  => $order->customer_id,
            'order_id' => $order->id,
            'message'  => "Order #{$order->id} confirmation",
            'channel'  => $channel,
            'status'   => $status,
        ]);
    }
}
