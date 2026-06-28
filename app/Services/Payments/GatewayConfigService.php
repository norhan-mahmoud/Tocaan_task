<?php

namespace App\Services\payments;

use App\Enums\PaymentGateway;
use App\Models\PaymentGatewayConfig;

class GatewayConfigService
{
    public function get(PaymentGateway $gateway): array
    {
        $config = PaymentGatewayConfig::query()
            ->where('gateway', $gateway->value)
            ->where('is_active', true)
            ->first();

        return [
            'api_key' => $config?->api_key
                ?? config("payment.{$gateway->value}.api_key"),

            'secret_key' => $config?->secret_key
                ?? config("payment.{$gateway->value}.secret_key"),

            'base_url' => $config?->base_url
                ?? config("payment.{$gateway->value}.base_url"),

            'settings' => $config?->settings
                ?? config("payment.{$gateway->value}.settings", []),
        ];
    }
}
