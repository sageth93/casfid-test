<?php

namespace App\Casfid\Scraper\Domain\News\Services;

use App\Casfid\Scraper\Domain\News\Model\Exceptions\NewsScraperNotFoundException;
use App\Casfid\Scraper\Domain\News\Model\NewsScraperFactoryInterface;
use App\Casfid\Scraper\Domain\News\Model\NewsScraperInterface;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;

class NewsScraperFactory implements NewsScraperFactoryInterface
{
    /**
     * @param iterable<NewsScraperInterface> $scrapers
     */
    public function __construct(
        protected iterable $scrapers
    ){
    }
    public function getScraper(SourceOrigin $origin): NewsScraperInterface
    {
        foreach ($this->scrapers as $scraper) {
            if( $scraper->origin()->equals($origin))
            {
                return $scraper;
            }
        }

        throw NewsScraperNotFoundException::create($origin);
    }
}
