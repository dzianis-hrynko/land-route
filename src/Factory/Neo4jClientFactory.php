<?php

declare(strict_types=1);

namespace App\Factory;

use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\ClientBuilder;
use Laudis\Neo4j\Contracts\ClientInterface;

final class Neo4jClientFactory
{
    public function create(
        string $driver,
        string $protocol,
        string $port,
        string $host,
        string $user,
        string $password,
        string $database
    ): ClientInterface {
        return ClientBuilder::create()
            ->withDriver(
                $driver,
                sprintf('%s://%s:%s?database=%s', $protocol, $host, $port, $database),
                Authenticate::basic($user, $password)
            )
            ->build();
    }
}
