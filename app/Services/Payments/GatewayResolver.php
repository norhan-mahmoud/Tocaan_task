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
}
