<?php

namespace App\Casfid\Scraper\Infrastructure\Scraper\Model;

class ScraperMissingFieldException extends ScraperException
{
    public static function create(string $field): self
    {
        return new self(sprintf("Scraper missing required field: %s", $field));
    }
}
