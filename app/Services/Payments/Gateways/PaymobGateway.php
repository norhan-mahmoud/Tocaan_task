<?php

namespace App\Services\Payments\Gateways;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Payments\GatewayConfigService;
use App\Services\Payments\Gateways\Contracts\PaymentGatewayInterface;
use App\Services\Payments\Gateways\Paymob\PaymobApiClient;

class PaymobGateway extends BasePaymentGateway implements PaymentGatewayInterface
{
    public function __construct(
        GatewayConfigService $configService,
        private readonly PaymobApiClient $client
    ) {
        $this->config = $configService->get(
            \App\Enums\PaymentGateway::PAYMOB
        );
    }

    public function pay(Order $order, array $data): Payment
    {
        /**
         * 1- Create Order
         */
        $orderResponse = $this->client->createOrder($order);


        if (! $orderResponse['success']) {
            throw new \Exception('Unable to create Paymob order.');
        }

        /**
         * 2- Generate Payment Key
         */
        $paymentKey = $this->client->createPaymentKey(
            $order,
            $orderResponse['data']['id'],
            $data
        );


        if (! $paymentKey['success']) {
            throw new \Exception('Unable to generate payment key.');
        }

        /**
         * 3- Save Payment
         */
        $payment = Payment::create([
            'order_id' => $order->id,
            'gateway' => \App\Enums\PaymentGateway::PAYMOB,
            'payment_method' => $orderResponse['data']['payment_method'],
            'transaction_id' => $orderResponse['data']['id'],
            'amount' => $orderResponse['data']['amount_cents'] / 100,
            'status' => 'pending',

            'metadata' => [
                'payment_key' => $paymentKey['data']['token'],
                'paymob_order' => $orderResponse['data'],
            ],
        ]);

        /**
         * 4- Return Payment
         */
        return $payment;
    }

    public function verify(array $payload): Payment
    {
        $payment = Payment::query()
            ->where(
                'transaction_id',
                $payload['order']['id']
            )
            ->firstOrFail();

        if ($payload['success'] && $payload['data']['captured']) {
            $payment->update([
                'status' => PaymentStatus::SUCCESSFUL,
                'paid_at' => now(),
            ]);
        } else {
            $payment->update([
                'status' => PaymentStatus::FAILED,
            ]);
        }

        return $payment;
    }
}
