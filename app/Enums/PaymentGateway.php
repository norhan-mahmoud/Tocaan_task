<?php

namespace App\Enums;

enum PaymentGateway:string
{
    case STRIPE = 'stripe';
    case PAYMOB = 'paymob';
}
