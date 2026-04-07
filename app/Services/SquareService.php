<?php

namespace App\Services;

use Square\SquareClient;
use Square\Environments;
use Square\Payments\Requests\CreatePaymentRequest;
use Square\Types\Money;
use Square\Types\Currency;
use Square\Exceptions\SquareException;
use Illuminate\Support\Str;

class SquareService
{
    protected SquareClient $client;
    protected string $locationId;

    public function __construct()
    {
        $this->client = new SquareClient(
            token: config('square.token'),
            options: [
                'baseUrl' => config('square.environment') === 'sandbox'
                    ? Environments::Sandbox->value
                    : Environments::Production->value,
            ]
        );

        $this->locationId = config('square.location_id');
    }

    /**
     * Charge a card using the tokenized sourceId from Square Web Payments SDK.
     *
     * @param  string $sourceId  Token from Square.js card.tokenize()
     * @param  float  $amount    Order total (e.g. 250.00) — converted to smallest unit internally
     * @param  int    $orderId   Your internal order ID (used as reference)
     * @return array  ['success' => bool, 'payment_id' => string|null, 'error' => string|null]
     */
    public function charge(string $sourceId, float $amount, int $orderId): array
    {
        try {
            $response = $this->client->payments->create(
                request: new CreatePaymentRequest([
                    'idempotencyKey' => Str::uuid()->toString(),
                    'sourceId'       => $sourceId,
                    'locationId'     => $this->locationId,
                    'referenceId'    => (string) $orderId,
                    'note'           => "GoGecko Order #$orderId",
                    'amountMoney'    => new Money([
                        'amount'   => (int) round($amount * 100), // smallest unit (cents/paise)
                        'currency' => Currency::Usd->value,       // sandbox uses USD; swap for production
                    ]),
                ])
            );

            $payment = $response->getPayment();

            return [
                'success'    => true,
                'payment_id' => $payment?->getId(),
                'error'      => null,
            ];

        } catch (SquareException $e) {
            return [
                'success'    => false,
                'payment_id' => null,
                'error'      => $e->getMessage(),
            ];
        } catch (\Throwable $e) {
            return [
                'success'    => false,
                'payment_id' => null,
                'error'      => 'An unexpected error occurred.',
            ];
        }
    }
}
