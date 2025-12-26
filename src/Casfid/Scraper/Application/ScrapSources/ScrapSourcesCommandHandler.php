<?php

namespace App\Casfid\Scraper\Application\ScrapSources;

use App\Casfid\Scraper\Domain\Source\Model\SourceFactoryInterface;
use App\Shared\Domain\Bus\Command\CommandHandler;

readonly class ScrapSourcesCommandHandler implements CommandHandler
{
    public function __construct(
        protected readonly SourceFactoryInterface $sourceFactory
    )
    {

    }

    public function handle(ScrapSourcesCommand $command): int
    {
        $sources = $this->sourceFactory->getSources($command->limit);
        return count($sources);
    }
}
