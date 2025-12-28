<?php

namespace App\Casfid\Scraper\Infrastructure\Scraper\Base;

use App\Casfid\Scraper\Infrastructure\Scraper\HtmlCrawlerFactory;
use App\Casfid\Scraper\Infrastructure\Scraper\HttpHtmlClient;
use App\Casfid\Scraper\Infrastructure\Scraper\Model\ScraperFetchUrlException;
use App\Casfid\Scraper\Infrastructure\Scraper\Model\ScraperMissingFieldException;
use Symfony\Component\DomCrawler\Crawler;

abstract class BaseScraper
{
    public function __construct(
        protected HttpHtmlClient $client,
        protected HtmlCrawlerFactory $crawlerFactory
    ) {}

    protected function fetch(string $url, int $retries = 2): string
    {
        while ($retries >= 0) {
            try {
                return $this->client->get($url);
            } catch (\Throwable $e) {
                if ($retries === 0) {
                    throw ScraperFetchUrlException::create($url);
                }

                $retries--;
                sleep(1);
            }
        }
    }

    protected function getCrawler(string $url): Crawler
    {
        return $this->crawlerFactory->parse($this->fetch($url));
    }

    protected function text(Crawler $node, string $selector, ?string $fallback = null): ?string
    {
        return $node->filter($selector)->count()
            ? trim($node->filter($selector)->text())
            : $fallback;
    }

    protected function attr(Crawler $node, string $selector, string $attr, ?string $fallback = null): ?string
    {
        return $node->filter($selector)->count()
            ? $node->filter($selector)->attr($attr)
            : $fallback;
    }

    protected function list(Crawler $node, string $selector): array
    {
        return $node->filter($selector)
            ->each(fn ($item) => trim($item->text()));
    }

    protected function validateNotEmpty(?string $value, string $field): void
    {
        if (!$value || trim($value) === '') {
            throw ScraperMissingFieldException::create($field);
        }
    }

    protected function validateArrayNotEmpty(array $values, string $field): void
    {
        if (empty($values)) {
            throw ScraperMissingFieldException::create($field);
        }
    }
}
