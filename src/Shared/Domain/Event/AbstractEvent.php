<?php

namespace App\Shared\Domain\Event;

use JsonSerializable;
use Safe\DateTimeImmutable;

abstract class AbstractEvent implements EventInterface, JsonSerializable
{
    private int $occurredOn;

    public function __construct()
    {
        $this->occurredOn = (new DateTimeImmutable())->getTimestamp();
    }

    public function occurredOn(): int
    {
        return $this->occurredOn;
    }
}
