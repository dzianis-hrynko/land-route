<?php

declare(strict_types=1);

namespace App\Entity;

final readonly class Route
{
    public function __construct(private array $route)
    {
    }

    public function getRoute(): array
    {
        return $this->route;
    }
}
