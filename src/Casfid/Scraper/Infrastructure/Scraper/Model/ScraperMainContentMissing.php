<?php

namespace App\Casfid\Scraper\Infrastructure\Scraper\Model;

class ScraperMainContentMissing extends ScraperException
{
    public static function create(string $class, string $url)
    {
        return new self(sprintf("%s: Main content article not found on: %s", $class, $url));
    }
}
