<?php

return [


    'paymob' => [
        'api_key' => env('PAYMOB_API_KEY'),
        'secret_key' => env('PAYMOB_SECRET_KEY'),
        'base_url' => env('PAYMOB_BASE_URL'),
        'settings' => [
            'integration_id' => env('PAYMOB_INTEGRATION_ID'),
        ],
    ],

    'stripe' => [
        'secret_key' => env('STRIPE_SECRET_KEY'),
        'publishable_key' => env('STRIPE_PUBLISHABLE_KEY'),
        'base_url' => env('STRIPE_BASE_URL'),
        'settings' => [
            'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        ],

    ],

];
