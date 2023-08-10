<?php

declare(strict_types=1);

namespace App\Provider;

use App\Client\CountryClientInterface;
use App\Mapper\CountryMapper;

final readonly class CountryProvider implements CountryProviderInterface
{
    public function __construct(private CountryClientInterface $countryClient)
    {
    }

    public function getCountriesList(): array
    {
        return CountryMapper::mapList($this->countryClient->getCountyList());
    }
}
