<?php

namespace App\Casfid\Scraper\Infrastructure\Source\Services\SourceScraper;

use App\Casfid\Scraper\Domain\Source\Model\SourceScraperInterface;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;

class ElPaisSourceScraper implements SourceScraperInterface
{

    public function origin(): SourceOrigin
    {
        return SourceOrigin::EL_PAIS;
    }

    public function scrap(int $limit): array
    {
        return [];
    }
}
