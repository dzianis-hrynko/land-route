<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Entity\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class RouteSerializer implements NormalizerInterface
{
    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof Route;
    }

    /**
     * @param Route $object
     */
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        return [
            'route' => $object->getRoute(),
        ];
    }
}
