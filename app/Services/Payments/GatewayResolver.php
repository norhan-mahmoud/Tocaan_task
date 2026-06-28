<?php

namespace App\Services\Payments;

use App\Enums\PaymentMethod;
use App\Services\Payments\Gateways\Contracts\PaymentGatewayInterface;

class GatewayResolver
{
    public function resolve(PaymentMethod $method): PaymentGatewayInterface
    {
       $gateway = app($method->gatewayClass());

        return app($method->gatewayClass());
    }

    //resolve the gateway based on the payment gateway
    public function resolveByGateway(string $gateway): PaymentGatewayInterface
    {
        $gateway = ucfirst($gateway);
        
    }
}
