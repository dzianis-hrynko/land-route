<?php

declare(strict_types=1);

namespace App\Client;

interface CountryClientInterface
{
    public function getCountyList(): array;
}
