<?php

namespace App\Casfid\Scraper\Domain\Source\Services;

use App\Casfid\Scraper\Domain\Source\Model\Exceptions\InvalidSourceScraperConfigurationException;
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
        $this->validateScrapers();

        $sources = [];

        foreach ($this->scrapers as $scraper) {
            $sources = array_merge($sources, $scraper->scrap($limit)) ;
        }
        return $sources;
    }

    private function validateScrapers(): void
    {
           $configuredOrigins = [];

           foreach ($this->scrapers as $scraper) {
               if( !($scraper instanceof SourceScraperInterface)) {
                    throw InvalidSourceScraperConfigurationException::invalidInterface($scraper::class);
               }

               $origin = $scraper->origin()->value;

               if (in_array($origin, $configuredOrigins, true)) {
                   throw InvalidSourceScraperConfigurationException::duplicatedOrigin($scraper::class);
               }

               $configuredOrigins[] = $origin;
           }
    }
}
