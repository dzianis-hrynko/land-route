<?php

declare(strict_types=1);

namespace spec\App\Mapper;

use App\Dto\CountryDto;
use App\Entity\Country;
use App\Exception\InvalidCountryException;
use App\Mapper\CountryMapper;
use PhpSpec\ObjectBehavior;

final class CountryMapperSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CountryMapper::class);
    }

    public function it_maps_one_country(): void
    {
        $country = $this::map(new CountryDto('BLR', ['pol']));
        $country->shouldBeAnInstanceOf(Country::class);
        $country->getCode()->shouldBe('BLR');
        $country->getBorderedWith()->shouldBe(['POL']);
    }

    public function it_maps_a_few_countries(): void
    {
        $countryDto = $this::mapList(
            [
                new CountryDto('BRL', ['POL']),
                new CountryDto('ukr', ['POL']),
            ]
        );
        $countryDto->shouldBeArray();
    }
}
