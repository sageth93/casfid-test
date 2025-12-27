<?php

namespace App\Casfid\Scraper\Infrastructure\Scraper\NewsScraper;

use App\Casfid\Scraper\Domain\News\Model\News;
use App\Casfid\Scraper\Domain\News\Model\NewsScraperInterface;
use App\Casfid\Scraper\Domain\Source\Model\Source;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;
use App\Casfid\Scraper\Infrastructure\Scraper\BaseScraper;

class ElMundoNewsScraper extends BaseScraper implements NewsScraperInterface
{

    public function origin(): SourceOrigin
    {
        return SourceOrigin::EL_MUNDO;
    }

    public function scrap(Source $source): News
    {
        // TODO: Implement scrap() method.
    }
}
