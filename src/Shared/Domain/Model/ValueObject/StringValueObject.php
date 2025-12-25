<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model\ValueObject;

class StringValueObject implements \JsonSerializable
{
    public function __construct(protected string $value)
    {
    }
    public function equals(StringValueObject $other): bool
    {
        return $this->value() === $other->value();
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
