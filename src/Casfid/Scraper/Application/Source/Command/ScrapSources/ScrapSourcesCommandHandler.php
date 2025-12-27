<?php

namespace App\Casfid\Scraper\Application\Source\Command\ScrapSources;

use App\Casfid\Scraper\Domain\Source\Event\NewPendingSourceEvent;
use App\Casfid\Scraper\Domain\Source\Model\SourceFactoryInterface;
use App\Casfid\Scraper\Domain\Source\Model\SourceRepositoryInterface;
use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Shared\Domain\Event\EventPublisherInterface;

class ScrapSourcesCommandHandler implements CommandHandler
{
    public function __construct(
        protected readonly SourceFactoryInterface $sourceFactory,
        protected readonly SourceRepositoryInterface $sourceRepository,
        protected readonly EventPublisherInterface $eventPublisher
    )
    {

    }

    public function handle(ScrapSourcesCommand $command): int
    {
        $sources = $this->sourceFactory->getSources($command->limit);

        $newSources = [];
        foreach ($sources as $source) {
            $hash = $source->hash();

            if($this->sourceRepository->sourceExists($hash)) {
                continue;
            }

            $this->sourceRepository->save($source);
            $newSources[] = $source;
        }

        foreach ($newSources as $source) {
            $this->eventPublisher->publish(
                new NewPendingSourceEvent($source->id())
            );
        }

        return count($newSources);
    }
}
