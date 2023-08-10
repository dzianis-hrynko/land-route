<?php

declare(strict_types=1);

namespace App\Dto;

final readonly class CountryDto
{
    public function __construct(
        private string $code,
        private array $borders
    ) {
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getBorders(): array
    {
        return $this->borders;
    }
}
