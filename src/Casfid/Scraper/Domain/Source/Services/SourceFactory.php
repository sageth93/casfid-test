<?php

namespace App\Casfid\Scraper\Domain\Source\Services;

use App\Casfid\Scraper\Domain\Source\Model\Exceptions\InvalidSourceScraperConfigurationException;
use App\Casfid\Scraper\Domain\Source\Model\SourceFactoryInterface;
use App\Casfid\Scraper\Domain\Source\Model\SourceScraperInterface;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;

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

        return [];
    }

    private function validateScrapers(): void
    {
           $configuredOrigins = [];

           foreach ($this->scrapers as $scraper) {
               if( !($scraper instanceof SourceScraperInterface)) {
                    throw InvalidSourceScraperConfigurationException::invalidInterface($scraper::class);
               }

               if( !SourceOrigin::tryFrom($scraper->origin()->value)) {
                   throw InvalidSourceScraperConfigurationException::invalidOrigin($scraper::class);
               }

               $origin = $scraper->origin()->value;

               if (in_array($origin, $configuredOrigins, true)) {
                   throw InvalidSourceScraperConfigurationException::duplicatedOrigin($scraper::class);
               }

               $configuredOrigins[] = $origin;
           }
    }
}
