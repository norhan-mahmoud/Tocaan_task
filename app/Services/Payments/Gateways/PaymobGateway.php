<?php

namespace App\Services\Payments\Gateways;

use App\Models\Order;
use App\Models\Payment;
use App\Services\payments\GatewayConfigService;
use App\Services\Payments\Gateways\Contracts\PaymentGatewayInterface;
use App\Services\Payments\Gateways\Paymob\PaymobAuthenticator;

class PaymobGateway extends BasePaymentGateway implements PaymentGatewayInterface
{

    public function __construct(
        GatewayConfigService $configService,
        private readonly PaymobAuthenticator $authenticator
    ) {
        $this->config = $configService->get(
            \App\Enums\PaymentGateway::PAYMOB
        );
    }

    public function pay(Order $order, array $data): Payment
    {
        $token = $this->authenticator->authenticate();

        $this->headers = [
            'Authorization' => 'Bearer '.$token,
        ];
        logger()->info('Paymob Gateway Headers: ', $this->headers);

        /**
         * هنا:
         *
         * 1- Create Order at Paymob
         * 2- Create Payment Key
         * 3- Save Payment Record
         * 4- Return Payment Model
         */

        // ....

        return $payment;
    }

    public function verify(array $payload): Payment
    {
        /**
         * Verify callback/webhook
         */

        // ...

        return $payment;
    }
}
