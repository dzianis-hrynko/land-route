<?php

declare(strict_types=1);

namespace App\Request;

use App\Exception\InvalidRouteRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class GetRouteRequest
{
    private Request $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest() ?? new Request();
    }

    public function getOrigin(): string
    {
        $origin = $this->request->get('origin');
        $this->validateIncomeValue($origin);
        return $this->stylizeIncomeValue($origin);
    }

    public function getDestination(): string
    {
        $destination = $this->request->get('destination');
        $this->validateIncomeValue($destination);
        return $this->stylizeIncomeValue($destination);
    }

    private function stylizeIncomeValue(string $incomeValue): string
    {
        return strtoupper($incomeValue);
    }

    private function validateIncomeValue(?string $incomeValue): void
    {
        if (
            empty($incomeValue)
            || !is_string($incomeValue)
            || strlen($incomeValue) !== 3
        ) {
            throw new InvalidRouteRequestException();
        }
    }
}
