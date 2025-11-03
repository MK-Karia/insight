<?php

namespace App\Exception;

use Exception;

class UserAlreadyExistException extends Exception
{
    public function __construct(string $message = "User already exist", int $code = 400, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
