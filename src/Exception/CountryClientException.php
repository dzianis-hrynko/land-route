<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

final class CountryClientException extends Exception
{
    public function __construct(string $message = 'Country provider service temporary unavailable')
    {
        parent::__construct($message, 503);
    }
}
