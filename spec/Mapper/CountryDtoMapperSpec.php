<?php

declare(strict_types=1);

namespace spec\App\Mapper;

use App\Dto\CountryDto;
use App\Exception\InvalidCountryException;
use App\Mapper\CountryDtoMapper;
use PhpSpec\ObjectBehavior;

final class CountryDtoMapperSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CountryDtoMapper::class);
    }

    public function it_maps_one_country(): void
    {
        $countryDto = $this::mapOne(['cca3' => 'BLR', 'borders' => ['POL']]);
        $countryDto->shouldBeAnInstanceOf(CountryDto::class);
        $countryDto->getCode()->shouldBe('BLR');
        $countryDto->getBorders()->shouldBe(['POL']);
    }

    public function it_maps_a_few_countries(): void
    {
        $countryDto = $this::mapList(
            [
                ['cca3' => 'UKR', 'borders' => ['POL']],
                ['cca3' => 'BLR', 'borders' => ['POL']],
            ]
        );
        $countryDto->shouldBeArray();
    }

    public function it_throws_exception(): void
    {
        $this->shouldThrow(InvalidCountryException::class)->during(
            'mapOne',
            [
                ['borders' => ['POL']]
            ]
        );
    }
}
