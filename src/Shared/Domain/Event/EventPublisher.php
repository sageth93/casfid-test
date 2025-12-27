<?php

namespace App\Shared\Domain\Event;

final class EventPublisher implements EventPublisherInterface
{
    /**
     * @param iterable<EventSubscriberInterface> $subscribers
     */
    public function __construct(
        private iterable $subscribers
    ) {
    }

    public function publish(EventInterface $event): void
    {
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($event)) {
                $subscriber->handle($event);
            }
        }
    }
}
