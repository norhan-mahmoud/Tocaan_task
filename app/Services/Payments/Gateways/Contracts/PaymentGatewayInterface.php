<?php

namespace App\Services\Payments\Gateways\Contracts;

use App\Models\Order;
use App\Models\Payment;

interface PaymentGatewayInterface
{
    public function pay(Order $order,array $data): Payment;

    public function verify(array $data): Payment;

}
