<?php

namespace App\Services\Payments;

use App\Enums\PaymentMethod;
use App\Models\Order;
use App\Models\Payment;

class PaymentService
{
    public function __construct(
        private readonly GatewayResolver $gatewayResolver
    ) {}

    public function pay(Order $order, array $data): Payment
    {
        $method = PaymentMethod::from($data['payment_method']);

        $gateway = $this->gatewayResolver->resolve(
            $method
        );

        return $gateway->pay($order, $data);
    }

    public function verify(array $payload): Payment
    {
        $method = PaymentMethod::from($payload['payment_method']);

        $gateway = $this->gatewayResolver->resolve(
            $method
        );

        return $gateway->verify($payload);
    }
}
