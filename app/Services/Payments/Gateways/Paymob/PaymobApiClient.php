<?php

namespace App\Services\Payments\Gateways\Paymob;

use App\Enums\PaymentGateway;
use App\Models\Order;
use App\Services\Payments\GatewayConfigService;
use App\Services\Payments\Gateways\BasePaymentGateway;

class PaymobApiClient extends BasePaymentGateway
{
    public function __construct(
        GatewayConfigService $configService,
        private readonly PaymobAuthenticator $authenticator
    ) {
        $this->config = $configService->get(
            PaymentGateway::PAYMOB
        );
    }

    protected function authenticate(): void
    {
        $this->headers = [
            'Authorization' => 'Bearer '.$this->authenticator->authenticate(),
        ];
    }

    public function createOrder(Order $order): array
    {
        $this->authenticate();


        return $this->buildRequest(
            'POST',
            '/api/ecommerce/orders',
            [
                'merchant_order_id' => $order->id,
                'amount_cents'      => $order->total_amount * 100,
                'items'             => [],
            ]
        );

    }

    public function createPaymentKey(
        Order $order,
        int $paymobOrderId,
        array $billingData
    ): array {
        $this->authenticate();

        return $this->buildRequest(
            'POST',
            '/api/acceptance/payment_keys',
            [
                'amount_cents'   => $order->total_amount * 100,
                'order_id'       => $paymobOrderId,
                'billing_data'   => $billingData,
                'integration_id' => $this->config['settings']['integration_id'],
                'expiration'     => 3600,
                'currency'       => "EGP",
                'billing_data'   => [
                    'first_name' => $billingData['first_name'] ,
                    'last_name' => $billingData['last_name'] ,
                    'email' => $billingData['email'] ,
                    'phone_number' => $billingData['phone_number'] ,
                    'apartment' => $billingData['apartment'] ,
                    'floor' => $billingData['floor'] ,
                    'street' => $billingData['street'] ,
                    'building' => $billingData['building'] ,
                    'city' => $billingData['city'],
                    'country' => $billingData['country'] ,
                ],

            ]
        );
    }

    public function transaction(int $transactionId): array
    {
        $this->authenticate();

        return $this->buildRequest(
            'GET',
            "/api/acceptance/transactions/{$transactionId}"
        );
    }
}
