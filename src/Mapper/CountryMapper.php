<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\CountryDto;
use App\Entity\Country;

final class CountryMapper
{
    public static function map(CountryDto $countryDto): Country
    {
        return new Country(
            self::stylizeProviderValue($countryDto->getCode()),
            self::stylizeProviderValues($countryDto->getBorders())
        );
    }

    public static function mapList(array $countries): array
    {
        return array_map(
            function (CountryDto $country): Country {
                return self::map($country);
            },
            $countries,
        );
    }

    private static function stylizeProviderValue(string $providerValue): string
    {
        return strtoupper($providerValue);
    }

    private static function stylizeProviderValues(array $providerValues): array
    {
        return array_map(
            static fn(string $providerValue): string => strtoupper($providerValue),
            $providerValues,
        );
    }
}
