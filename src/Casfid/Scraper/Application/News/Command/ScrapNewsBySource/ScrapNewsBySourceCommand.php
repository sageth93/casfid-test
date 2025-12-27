<?php

namespace App\Casfid\Scraper\Application\News\Command\ScrapNewsBySource;

use App\Shared\Domain\Bus\Command\Command;

class ScrapNewsBySourceCommand implements Command
{
    public function __construct(
        protected readonly string $sourceId
    )
    {
    }

    public function sourceId(): string
    {
        return $this->sourceId;
    }
}
