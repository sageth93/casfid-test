<?php

namespace App\Casfid\Scraper\Domain\Source\Model;

use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;

interface SourceScraperInterface
{
    public function origin(): SourceOrigin;

    public function newsIndex(): string;

    /** @return Source[] */
    public function scrap(int $limit): array;
}
