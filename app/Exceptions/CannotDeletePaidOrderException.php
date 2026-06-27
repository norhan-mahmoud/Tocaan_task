<?php

namespace App\Exceptions;

use Exception;

class CannotDeletePaidOrderException extends Exception
{
    public function __construct(
        string $message = 'This order cannot be deleted because it has associated payment records.',
        int $code = 409
    ) {
        parent::__construct($message, $code);
    }
}
