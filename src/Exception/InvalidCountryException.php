<?php

declare(strict_types=1);

namespace App\Exception;

use Psr\Log\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

final class InvalidCountryException extends InvalidArgumentException
{
    public function __construct(string $message = "Invalid country")
    {
        parent::__construct($message, code: Response::HTTP_BAD_REQUEST);
    }
}
