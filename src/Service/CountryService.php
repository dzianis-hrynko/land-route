<?php

declare(strict_types=1);

namespace App\Service;

use App\Provider\CountryProvider;
use App\Manager\CountryManager;

final readonly class CountryService
{
    public function __construct(
        private CountryProvider $countryProvider,
        private CountryManager $countryManager,
    ) {
    }

    public function synchronize(): void
    {
        $countries = $this->countryProvider->getCountriesList();
        $this->updateCountries($countries);
        $this->updateBorders($countries);
    }

    private function updateCountries(array $countries): void
    {
        $this->countryManager->saveAll($countries);
    }

    private function updateBorders(array $countries): void
    {
        $this->countryManager->createRelationsForAllCountries($countries);
    }
}
