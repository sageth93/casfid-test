<?php

namespace App\Casfid\Scraper\Infrastructure\Source\Subscribers;

use App\Casfid\Scraper\Application\News\ScrapNewsBySource\ScrapNewsBySourceCommand;
use App\Casfid\Scraper\Domain\Source\Event\NewPendingSourceEvent;
use App\Shared\Domain\Event\EventInterface;
use App\Shared\Domain\Event\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class NewPendingSourceSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected readonly MessageBusInterface $messageBus
    )
    {
    }

    public function handle(EventInterface $event): void
    {
        if(!$event instanceof NewPendingSourceEvent)
        {
            return;
        }

        $this->messageBus->dispatch(
            new ScrapNewsBySourceCommand($event->sourceId())
        );
    }

    public function isSubscribedTo(EventInterface $event): bool
    {
        return $event instanceof NewPendingSourceEvent;
    }
}
