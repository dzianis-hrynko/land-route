<?php

declare(strict_types=1);

namespace App\Entity;

final readonly class Country
{
    public function __construct(
        private string $code,
        private array $borderedWith
    ) {
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getBorderedWith(): array
    {
        return $this->borderedWith;
    }
}
