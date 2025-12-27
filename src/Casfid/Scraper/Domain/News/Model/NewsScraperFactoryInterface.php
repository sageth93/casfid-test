<?php

namespace App\Casfid\Scraper\Domain\News\Model;

use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;

interface NewsScraperFactoryInterface
{
    public function getScraper(SourceOrigin $origin): NewsScraperInterface;
}
