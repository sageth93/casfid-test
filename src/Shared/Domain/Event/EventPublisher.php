<?php

namespace App\Shared\Domain\Event;

final class EventPublisher implements EventPublisherInterface
{
    private static ?self $instance = null;

    /**
     * @param array<EventSubscriberInterface> $subscribers
     */
    public function __construct(
        private array $subscribers = []
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

    public function subscribe(EventSubscriberInterface $eventSubscriber): EventSubscriberId
    {
        $id = EventSubscriberId::create();
        $this->subscribers[$id->toString()] = $eventSubscriber;

        return $id;
    }

    public function unsubscribe(EventSubscriberId $id): void
    {
        unset($this->subscribers[$id->toString()]);
    }

    public static function instance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function ofId(EventSubscriberId $id): ?EventSubscriberInterface
    {
        return $this->subscribers[$id->toString()] ?? null;
    }
}
