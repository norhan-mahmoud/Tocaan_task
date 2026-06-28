<?php

namespace App\Models;

use App\Enums\PaymentGateway;
use Illuminate\Database\Eloquent\Model;

class PaymentGatewayConfig extends Model
{
    protected $fillable = [
        'gateway',
        'api_key',
        'secret_key',
        'base_url',
        'is_active',
        'settings',
    ];

    protected $casts = [
        'gateway' => PaymentGateway::class,
        'is_active' => 'boolean',
        'settings' => 'array',
    ];
}
