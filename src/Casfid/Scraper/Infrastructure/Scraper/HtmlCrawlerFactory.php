<?php

namespace App\Casfid\Scraper\Infrastructure\Scraper;

use Symfony\Component\DomCrawler\Crawler;

readonly class HtmlCrawlerFactory
{
    public function parse(string $html): Crawler
    {
        return new Crawler($html);
    }
}
