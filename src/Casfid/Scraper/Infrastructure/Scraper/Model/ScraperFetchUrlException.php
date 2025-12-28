<?php

namespace App\Casfid\Scraper\Infrastructure\Scraper\Model;

class ScraperFetchUrlException extends ScraperException
{
    public static function create(string $url): self
    {
        return new self(sprintf('Error fetching url: %s', $url));
    }
}
