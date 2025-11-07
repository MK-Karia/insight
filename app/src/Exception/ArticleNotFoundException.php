<?php

namespace App\Exception;

use Exception;

class ArticleNotFoundException extends Exception
{
    public function __construct(string $message = "Article not found", int $code = 404, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
