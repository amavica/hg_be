<?php

namespace App\Exception\Security;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserNotFoundException extends RuntimeException
{
    /**
     * @inheritDoc
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, Response::HTTP_UNAUTHORIZED, $previous);
    }
}
