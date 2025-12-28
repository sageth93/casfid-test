<?php

namespace App\Casfid\Scraper\Infrastructure\Console\Command;

use App\Casfid\Scraper\Application\Source\Command\ScrapSources\ScrapSourcesCommand;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('casfid:scrap-news', 'Scrap news from sources')]
class ScrapNewsCommand extends Command
{
    public function __construct(
        protected readonly CommandBus $commandBus
    )
    {
        parent::__construct();
    }
    public function __invoke(
        SymfonyStyle $io,
        #[Option(description: 'Number of news to scrap for each origin')] int $limit = 5
    ): int
    {
        try {
            $sourcesFind = $this->commandBus->handle(new ScrapSourcesCommand($limit));
        } catch (\Throwable $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }

        $io->success("Scraped {$sourcesFind} news");
        return Command::SUCCESS;
    }
}
