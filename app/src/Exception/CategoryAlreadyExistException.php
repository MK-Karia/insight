<?php

namespace App\Exception;

use Exception;

class CategoryAlreadyExistException extends Exception
{
    public function __construct(string $message = "Category already exist", int $code = 400, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
