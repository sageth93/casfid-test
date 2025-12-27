<?php

namespace App\Shared\Domain\Event;

interface EventPublisherInterface
{
    public function publish(EventInterface $event): void;
}
