<?php

namespace App\Services\Payments\Gateways;

use Exception;
use Illuminate\Support\Facades\Http;

class BasePaymentGateway
{
    protected $config;

    protected array $headers = [];


    protected function buildRequest(
        string $method,
        string $url,
        ?array $data = null,
        string $type = 'json'
    ): array {
        try {
            $response = Http::withHeaders($this->headers)
                ->send($method, $this->config['base_url'].$url, [
                    $type => $data,
                ]);


            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'data' => $response->json(),
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'status' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }
}
