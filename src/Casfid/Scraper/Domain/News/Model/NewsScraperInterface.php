<?php

namespace App\Casfid\Scraper\Domain\News\Model;

use App\Casfid\Scraper\Domain\Source\Model\Source;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;

interface NewsScraperInterface
{
    public function origin(): SourceOrigin;
    public function scrap(Source $source): News;
}
