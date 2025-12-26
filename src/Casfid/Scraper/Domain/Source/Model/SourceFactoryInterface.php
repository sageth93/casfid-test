<?php

namespace App\Casfid\Scraper\Domain\Source\Model;

interface SourceFactoryInterface
{
    /** @return Source[] */
    public function getSources(int $limit): array;
}
