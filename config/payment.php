<?php

return [


    'paymob' => [
        'api_key' => env('PAYMOB_API_KEY'),
        'secret_key' => env('PAYMOB_SECRET_KEY'),
        'base_url' => env('PAYMOB_BASE_URL'),
    ],

    'stripe' => [
        'secret_key' => env('STRIPE_SECRET_KEY'),
        'publishable_key' => env('STRIPE_PUBLISHABLE_KEY'),
        'base_url' => env('STRIPE_BASE_URL'),
    ],

];
