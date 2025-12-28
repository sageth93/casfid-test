<?php

namespace App\Casfid\Scraper\Infrastructure\Scraper\Base;

use App\Casfid\Scraper\Domain\News\Model\News;
use App\Casfid\Scraper\Domain\News\Model\NewsScraperInterface;
use App\Casfid\Scraper\Domain\News\Model\ValueObject\NewsAuthor;
use App\Casfid\Scraper\Domain\News\Model\ValueObject\NewsContent;
use App\Casfid\Scraper\Domain\News\Model\ValueObject\NewsId;
use App\Casfid\Scraper\Domain\News\Model\ValueObject\NewsTitle;
use App\Casfid\Scraper\Domain\Source\Model\Source;

abstract class BaseNewsScraper extends BaseScraper implements NewsScraperInterface
{
    protected function createNews(
        Source $source,
        string $title,
        array $content,
        array $authors = [],
        ?string $rawDate = null
    ): News
    {
        $this->validateNotEmpty($title, 'title');
        $this->validateArrayNotEmpty($content, 'content');

        $author = !empty($authors) ? implode(', ', $authors) : 'Unknown';

        try {
            $date = $rawDate ? new \DateTimeImmutable($rawDate) : new \DateTimeImmutable();
        } catch (\Throwable) {
            $date = new \DateTimeImmutable();
        }

        return new News(
            id: NewsId::create(),
            title: new NewsTitle($title),
            content: new NewsContent(implode("\n", $content)),
            author: new NewsAuthor($author),
            date: $date,
            source: $source,
            createdAt: new \DateTimeImmutable(),
            updatedAt: null,
            deletedAt: null
        );
    }
}
