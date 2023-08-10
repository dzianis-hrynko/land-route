<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{
    public function noContentResponse(): Response
    {
        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    public function jsonResponse(mixed $data = []): JsonResponse
    {
        return $this->json($data);
    }

    public function errorResponse(string $message): JsonResponse
    {
        return new JsonResponse(
            ['message' => $message],
            Response::HTTP_BAD_REQUEST,
        );
    }
}
