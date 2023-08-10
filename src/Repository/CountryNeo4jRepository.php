<?php

declare(strict_types=1);

namespace App\Repository;

use Laudis\Neo4j\Client;
use Laudis\Neo4j\Databags\Statement;
use Laudis\Neo4j\Databags\SummarizedResult;

final readonly class CountryNeo4jRepository implements CountryNeo4jRepositoryInterface
{
    public function __construct(private Client $client)
    {
    }

    public function run(string $query, array $parameters): SummarizedResult
    {
        return $this->client->run($query, $parameters);
    }

    public function runStatements(array $statements): void
    {
        $this->client->runStatements($statements);
    }

    public function runStatement(Statement $statement): void
    {
        $this->client->runStatement($statement);
    }
}
