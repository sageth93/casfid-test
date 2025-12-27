<?php

namespace App\Casfid\Scraper\Application\Source\Command\ScrapSources;

use App\Shared\Domain\Bus\Command\Command;

readonly class ScrapSourcesCommand implements Command
{
    public function __construct(
        public int $limit
    )
    {
    }
}
