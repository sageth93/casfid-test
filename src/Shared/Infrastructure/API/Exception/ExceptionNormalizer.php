<?php

namespace App\Shared\Infrastructure\API\Exception;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ExceptionNormalizer implements NormalizerInterface
{
    public function normalize($object, ?string $format = null, array $context = []): array
    {
        return [
            'message' => $object->getMessage(),
            'code' => $object->getStatusCode(),
        ];
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof FlattenException;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            FlattenException::class => __CLASS__ === self::class
        ];
    }
}
