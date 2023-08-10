<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Country;
use App\Entity\Route;
use App\Mapper\RouteMapper;
use App\Repository\CountryNeo4jRepositoryInterface;
use Laudis\Neo4j\Databags\Statement;

final readonly class CountryManager
{
    private const COUNTRY_CODES_BETWEEN_ORIGIN_DESTINATION_QUERY =
        '
        MATCH (start:Country {code: $origin}), (end:Country {code: $destination})
        MATCH path = shortestPath((start)-[:BORDERED_WITH*]-(end))
        RETURN [country IN nodes(path) | country.code] AS countryCodes
        ';

    public function __construct(
        private CountryNeo4jRepositoryInterface $countryNeo4jRepository
    ) {
    }

    public function getListOfCountriesBetweenOriginAndDestination(string $origin, string $destination): Route
    {
        $countryCodes = $this->countryNeo4jRepository->run(
            self::COUNTRY_CODES_BETWEEN_ORIGIN_DESTINATION_QUERY,
            [
                    'origin' => $origin,
                    'destination' => $destination
                ],
        )
            ->getResults()
            ->toRecursiveArray();

        return RouteMapper::map($countryCodes[0]['countryCodes'] ?? []);
    }

    public function saveAll(array $countries): void
    {
        $statements = [];
        foreach ($countries as $country) {
            if (empty($country->getBorderedWith())) {
                $statements[] = $this->createCountryNodeStatementByCode($country->getCode());
            } else {
                $statements[] = $this->createCountryNodeStatementByCode($country->getCode());
                array_merge(
                    $statements,
                    $this->createCountryStatementsForBorders($country->getBorderedWith()),
                );
            }
        }

        $this->countryNeo4jRepository->runStatements($statements);
    }

    public function createRelationsForAllCountries(array $countries): void
    {
        $statements = [];
        foreach ($countries as $country) {
            if (!empty($country->getBorderedWith())) {
                $statements = array_merge(
                    $statements,
                    $this->createCountryBorderRelationStatements($country)
                );
            }
        }

        $this->countryNeo4jRepository->runStatements($statements);
    }

    private function createCountryStatementsForBorders(array $borderedCountries): array
    {
        return array_map(
            fn($countryCode): Statement => $this->createCountryNodeStatementByCode($countryCode),
            $borderedCountries,
        );
    }

    private function createCountryBorderRelationStatements(Country $country): array
    {
        $statements = [];
        foreach ($country->getBorderedWith() as $borderCode) {
            $statements[] = $this->createBorderRelation($country->getCode(), $borderCode);
        }

        return $statements;
    }

    private function createCountryNodeStatementByCode(string $countryCode): Statement
    {
        return Statement::create(
            sprintf('MERGE (%s:Country {code: $code})', $countryCode),
            ['code' => $countryCode]
        );
    }

    private function createBorderRelation(string $countryCode1, string $countryCode2): Statement
    {
        return Statement::create(
            '
                    MATCH (a:Country {code: $countryCode1}), (b:Country {code: $countryCode2})
                    WHERE NOT EXISTS((a)-[:BORDERED_WITH]->(b))
                    MERGE (a)-[r:BORDERED_WITH]->(b)
                ',
            [
                'countryCode1' => $countryCode1,
                'countryCode2' => $countryCode2,
            ]
        );
    }
}
