<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Entity\Route;

final class RouteMapper
{
    public static function map(array $route): Route
    {
        return new Route($route);
    }
}
