<?php

namespace App\Services\Payments;

use App\Enums\OrderStatus;
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
        if ($order->status !== OrderStatus::CONFIRMED) {

            throw new \Exception('Order must be confirmed before making a payment.');
        }
        $method = PaymentMethod::from($data['payment_method']);

        $gateway = $this->gatewayResolver->resolve(
            $method
        );

        return $gateway->pay($order, $data);
    }

    public function verify(
        string $gateway,
        array $payload): Payment
    {

        $gatewayClass = config("payment.{$gateway}.gateway_class");

        if (! $gatewayClass) {
            throw new \Exception("Payment gateway class not found for {$gateway}.");
        }

        $gateway = app($gatewayClass);

        return $gateway->verify($payload);
    }
}
