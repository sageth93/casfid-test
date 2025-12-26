<?php

namespace App\Casfid\Scraper\Domain\Source\Services;

use App\Casfid\Scraper\Domain\Source\Model\SourceFactoryInterface;
use App\Casfid\Scraper\Domain\Source\Model\SourceScraperInterface;

class SourceFactory implements SourceFactoryInterface
{
    /**
     * @param iterable<SourceScraperInterface> $scrapers
     */
    public function __construct(
        protected iterable $scrapers
    ){
    }

    public function getSources(int $limit): array
    {
        return [];
    }
}
