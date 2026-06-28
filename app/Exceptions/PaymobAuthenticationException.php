<?php

namespace App\Exceptions;

use Exception;

class PaymobAuthenticationException extends Exception
{
    public function __construct(
        string $message = 'Failed to authenticate with Paymob.',
        int $code = 409
    ) {
        parent::__construct($message, $code);
    }}
