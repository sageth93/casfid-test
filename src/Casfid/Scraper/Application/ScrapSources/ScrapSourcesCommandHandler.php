<?php

namespace App\Casfid\Scraper\Application\ScrapSources;

use App\Casfid\Scraper\Domain\Source\Model\SourceFactoryInterface;
use App\Casfid\Scraper\Domain\Source\Model\SourceRepositoryInterface;
use App\Shared\Domain\Bus\Command\CommandHandler;

class ScrapSourcesCommandHandler implements CommandHandler
{
    public function __construct(
        protected readonly SourceFactoryInterface $sourceFactory,
        protected readonly SourceRepositoryInterface $sourceRepository
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

        return count($newSources);
    }
}
