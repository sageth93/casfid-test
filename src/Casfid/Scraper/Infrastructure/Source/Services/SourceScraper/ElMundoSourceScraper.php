<?php

namespace App\Casfid\Scraper\Infrastructure\Source\Services\SourceScraper;

use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;
use App\Casfid\Scraper\Infrastructure\Source\Services\BaseSourceScraper;

class ElMundoSourceScraper extends BaseSourceScraper
{
    public function origin(): SourceOrigin
    {
        return SourceOrigin::EL_MUNDO;
    }

    public function newsIndex(): string
    {
        return 'https://www.elmundo.es/';
    }

    public function scrap(int $limit): array
    {
        return [];
    }
}
