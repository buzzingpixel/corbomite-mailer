<?php

declare(strict_types=1);

namespace buzzingpixel\corbomitemailer\exceptions;

use Exception;
use Throwable;

class InvalidEmailModelException extends Exception
{
    public function __construct(
        string $message = 'Invalid email model',
        int $code = 500,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
