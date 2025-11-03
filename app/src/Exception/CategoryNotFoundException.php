<?php

namespace App\Exception;

use Exception;

class CategoryNotFoundException extends Exception
{
    public function __construct(string $message = "Category not found", int $code = 404, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
