<?php

declare(strict_types=1);

namespace App\Repository;

use Laudis\Neo4j\Databags\Statement;
use Laudis\Neo4j\Databags\SummarizedResult;

interface CountryNeo4jRepositoryInterface
{
    public function run(string $query, array $parameters): SummarizedResult;
    public function runStatements(array $statements): void;
    public function runStatement(Statement $statement): void;
}
