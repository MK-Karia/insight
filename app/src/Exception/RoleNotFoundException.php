<?php

namespace App\Exception;

use Exception;

class RoleNotFoundException extends Exception
{
    public function __construct(string $message = "Role not found", int $code = 404, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
