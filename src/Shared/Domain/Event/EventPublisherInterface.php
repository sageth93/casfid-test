<?php

namespace App\Shared\Domain\Event;

interface EventPublisherInterface
{
    public function publish(EventInterface $event): void;
    public function subscribe(EventSubscriberInterface $eventSubscriber): EventSubscriberId;
    public function ofId(EventSubscriberId $id): ?EventSubscriberInterface;
}
