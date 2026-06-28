<?php

namespace App\Enums;

use App\Services\Payments\Gateways\PaymobGateway;
use App\Services\Payments\Gateways\StripeGateway;
enum PaymentMethod :string
{
    case VISA = 'visa';
    case MASTERCARD = 'mastercard';
    case MEEZA = 'meeza';
    case WALLET = 'wallet';
    case APPLE_PAY = 'apple_pay';
    case TBC = 'tbc';
    case CASH = 'cash';


   public function gatewayClass(): string
    {
        return match ($this) {
            self::VISA,
            self::MASTERCARD,
            self::MEEZA,
            self::WALLET,
            self::TBC,
            self::CASH => PaymobGateway::class,

            self::APPLE_PAY => StripeGateway::class,
        };
    }


}
