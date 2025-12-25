<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model\ValueObject;

use Symfony\Component\Uid\Uuid;

class UuidValueObject extends Uuid
{
    public static function create(): static
    {
        return new static(Uuid::v7()->uid);
    }
}
