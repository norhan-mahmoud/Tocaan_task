<?php

namespace App\Services\Payments\Gateways\Paymob;

use App\Enums\PaymentGateway;
use App\Exceptions\PaymobAuthenticationException;
use App\Services\payments\GatewayConfigService;
use App\Services\Payments\Gateways\BasePaymentGateway;

class PaymobAuthenticator extends BasePaymentGateway
{

    public function __construct(
        GatewayConfigService $configService
    ) {
        $this->config = $configService->get(
            PaymentGateway::PAYMOB
        );
    }

    public function authenticate(): string
    {
        $response = $this->buildRequest(
            'POST',
            '/api/auth/tokens',
            [
                'api_key' => $this->config['api_key'],
            ]
        );

        if (! ($response['success'] ?? false)) {
            throw new PaymobAuthenticationException();
        }

        $token = $response['token']
            ?? $response['data']['token']
            ?? null;

        if (! $token) {
            throw new PaymobAuthenticationException(
                'Authentication token not found.'
            );
        }

        return $token;
    }
}
