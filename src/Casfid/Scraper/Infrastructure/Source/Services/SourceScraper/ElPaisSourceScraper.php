<?php

namespace App\Casfid\Scraper\Infrastructure\Source\Services\SourceScraper;

use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;
use App\Casfid\Scraper\Infrastructure\Source\Services\BaseSourceScraper;

class ElPaisSourceScraper extends BaseSourceScraper
{

    public function origin(): SourceOrigin
    {
        return SourceOrigin::EL_PAIS;
    }

    public function newsIndex(): string
    {
        return 'https://elpais.com/';
    }

    public function scrap(int $limit): array
    {
        return [];
    }
}
