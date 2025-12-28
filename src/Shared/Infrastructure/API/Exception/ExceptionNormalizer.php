<?php

namespace App\Shared\Infrastructure\API\Exception;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Throwable;

class ExceptionNormalizer implements NormalizerInterface
{
    public function normalize($data, ?string $format = null, array $context = []): array
    {
        if (!$data instanceof FlattenException) {
            $data = FlattenException::createFromThrowable($data);
        }

        $status = $data->getStatusCode() ?? 500;
        $title = $this->resolveTitle($status);

        return [
            'title' => $title,
            'status' => $status,
            'detail' => $data->getMessage(),
        ];
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Throwable || $data instanceof FlattenException;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Throwable::class        => true,
            FlattenException::class => true,
        ];
    }

    private function resolveTitle(int $status): string
    {
        return match ($status) {
            304 => 'Not Modified',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Resource Not Found',
            409 => 'Conflict',
            422 => 'Unprocessable Entity',
            500 => 'Internal Server Error',
            default => 'Unknown Error',
        };
    }
}
