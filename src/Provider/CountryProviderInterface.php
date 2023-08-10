<?php

declare(strict_types=1);

namespace App\Provider;

interface CountryProviderInterface
{
    public function getCountriesList(): array;
}
