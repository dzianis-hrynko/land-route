<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\InvalidRouteRequestException;
use App\Request\GetRouteRequest;
use App\Service\RouteService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class RouteController extends BaseController
{
    public function __construct(
        private readonly RouteService $routeService,
    ) {
    }

    #[Route(path: '/routing/{origin}/{destination}', methods: ['GET'])]
    public function route(GetRouteRequest $request): JsonResponse
    {
        try {
            $origin = $request->getOrigin();
            $destination = $request->getDestination();
            if ($origin === $destination) {
                return $this->errorResponse('Origin and destination countries are the same.');
            }

            $route = $this->routeService->getRouteByOriginAndDestination($origin, $destination);
        } catch (InvalidRouteRequestException $exception) {
            return $this->errorResponse($exception->getMessage());
        }

        if (empty($route->getRoute())) {
            return $this->errorResponse('There is no land crossing');
        }
        return $this->jsonResponse($route);
    }
}
