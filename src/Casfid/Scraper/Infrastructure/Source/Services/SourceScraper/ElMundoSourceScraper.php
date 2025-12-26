<?php

namespace App\Casfid\Scraper\Infrastructure\Source\Services\SourceScraper;

use App\Casfid\Scraper\Domain\Source\Model\SourceScraperInterface;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;

class ElMundoSourceScraper implements SourceScraperInterface
{
    public function origin(): SourceOrigin
    {
        return SourceOrigin::EL_MUNDO;
    }

    public function scrap(int $limit): array
    {
        return [];
    }
}
