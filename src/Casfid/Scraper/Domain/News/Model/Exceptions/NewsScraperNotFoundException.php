<?php

namespace App\Casfid\Scraper\Domain\News\Model\Exceptions;

use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;

class NewsScraperNotFoundException extends \RuntimeException
{
    public static function create(SourceOrigin $origin): self
    {
        return new self(sprintf('No news scraper found for origin %s', $origin->value));
    }
}
