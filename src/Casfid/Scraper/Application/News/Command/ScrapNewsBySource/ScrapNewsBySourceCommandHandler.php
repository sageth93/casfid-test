<?php

namespace App\Casfid\Scraper\Application\News\Command\ScrapNewsBySource;

use App\Casfid\Scraper\Domain\News\Model\NewsRepositoryInterface;
use App\Casfid\Scraper\Domain\News\Model\NewsScraperFactoryInterface;
use App\Casfid\Scraper\Domain\Source\Model\Exceptions\SourceAlreadyBeenScrapedException;
use App\Casfid\Scraper\Domain\Source\Model\Exceptions\SourceNotFoundException;
use App\Casfid\Scraper\Domain\Source\Model\SourceRepositoryInterface;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceId;
use App\Shared\Domain\Bus\Command\CommandHandler;

class ScrapNewsBySourceCommandHandler implements CommandHandler
{
    public function __construct(
        protected readonly SourceRepositoryInterface $sourceRepository,
        protected readonly NewsScraperFactoryInterface $newsScraperFactory,
        protected readonly NewsRepositoryInterface $newsRepository
    )
    {
    }

    public function handle(ScrapNewsBySourceCommand $command): void
    {
        $source = $this->sourceRepository->findById(
            new SourceId($command->sourceId())
        );

        if(!$source) {
            throw SourceNotFoundException::create($command->sourceId());
        }

        if(!$source->isPending()) {
            throw SourceAlreadyBeenScrapedException::create($command->sourceId());
        }

        $news = $this->newsScraperFactory
            ->getScraper($source->origin())
            ->scrap($source);

        $news->source()->scrapDone();

        $this->newsRepository->save($news);
    }
}
