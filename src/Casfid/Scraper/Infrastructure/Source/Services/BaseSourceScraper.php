<?php

namespace App\Casfid\Scraper\Infrastructure\Source\Services;

use App\Casfid\Scraper\Domain\Source\Model\SourceScraperInterface;
use Symfony\Component\DomCrawler\Crawler;

abstract class BaseSourceScraper implements SourceScraperInterface
{
    public function __construct(
        protected HttpHtmlClient $client,
        protected HtmlCrawlerFactory $crawlerFactory
    ) {}

    protected function fetch(string $url): string
    {
        return $this->client->get($url);
    }

    protected function getCrawler(string $url): Crawler
    {
        return $this->crawlerFactory->parse($this->fetch($url));
    }
}
