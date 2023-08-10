<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Route;
use App\Manager\CountryManager;

final readonly class RouteService
{
    public function __construct(
        private bool $syncCountries,
        private CountryManager $countryManager,
        public CountryService $countryService
    ) {
        if ($this->syncCountries) {
            $countryService->synchronize();
        }
    }

    public function getRouteByOriginAndDestination(string $origin, string $destination): Route
    {
        return $this->countryManager->getListOfCountriesBetweenOriginAndDestination($origin, $destination);
    }
}
