<?php

namespace App\Casfid\Scraper\Domain\Source\Model\Exceptions;

class SourceAlreadyBeenScrapedException extends \RuntimeException
{
    public static function create(string $sourceId): self
    {
        return new self(sprintf('Source with id %s has already been scraped', $sourceId));
    }
}
