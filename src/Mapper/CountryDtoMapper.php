<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\CountryDto;
use App\Exception\InvalidCountryException;

final class CountryDtoMapper
{
    private const COUNTRY_CODE = 'cca3';
    private const COUNTRY_BORDERS = 'borders';

    public static function mapOne(array $country): CountryDto
    {
        self::validateCountry($country);
        return new CountryDto(
            $country[self::COUNTRY_CODE],
            $country[self::COUNTRY_BORDERS],
        );
    }

    public static function mapList(array $countries): array
    {
        return array_map(
            function (array $country): CountryDto {
                self::validateCountry($country);
                return self::mapOne($country);
            },
            $countries,
        );
    }

    private static function validateCountry(array $country): void
    {
        if (
            !isset($country[self::COUNTRY_CODE])
            || !isset($country[self::COUNTRY_BORDERS])
            || !is_array($country[self::COUNTRY_BORDERS])
        ) {
            throw new InvalidCountryException('Provided country has not got mandatory fields');
        }
    }
}
