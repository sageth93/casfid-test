<?php

namespace App\Shared\Domain\Event;

interface EventSubscriberInterface
{
    public function handle(EventInterface $event): void;
    public function isSubscribedTo(EventInterface $event): bool;
}
