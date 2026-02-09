<?php

namespace App\Exceptions;

use Exception;

class DomainException extends Exception
{
    protected string $errorCode;

    public function __construct(string $message, string $errorCode)
    {
        parent::__construct($message);
        $this->errorCode = $errorCode;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
}

// Esto nos permite lanzar errores con significado.
