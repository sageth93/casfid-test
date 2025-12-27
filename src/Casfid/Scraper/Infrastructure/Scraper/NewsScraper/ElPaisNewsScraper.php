<?php

namespace App\Casfid\Scraper\Infrastructure\Scraper\NewsScraper;

use App\Casfid\Scraper\Domain\News\Model\News;
use App\Casfid\Scraper\Domain\News\Model\NewsScraperInterface;
use App\Casfid\Scraper\Domain\News\Model\ValueObject\NewsAuthor;
use App\Casfid\Scraper\Domain\News\Model\ValueObject\NewsContent;
use App\Casfid\Scraper\Domain\News\Model\ValueObject\NewsId;
use App\Casfid\Scraper\Domain\News\Model\ValueObject\NewsTitle;
use App\Casfid\Scraper\Domain\Source\Model\Source;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;
use App\Casfid\Scraper\Infrastructure\Scraper\BaseScraper;

class ElPaisNewsScraper extends BaseScraper implements NewsScraperInterface
{

    public function origin(): SourceOrigin
    {
        return SourceOrigin::EL_PAIS;
    }

    public function scrap(Source $source): News
    {
        $crawler = $this->getCrawler($source->url());

        $article = $crawler->filter('article#main-content')->first();

        $title = trim($article->filter('header h1')->text());
        $authorsList = $article->filter('div[data-dtm-region=articulo_firma] a')
            ->each(fn ($node) => trim($node->text()));
        $author = implode(', ', $authorsList);
        $rawDate = $article->filter('time')->first()->attr('datetime');
        $content = $article->filter('div[data-dtm-region=articulo_cuerpo] p')
            ->each(fn ($node) => trim($node->text()));

        $content = implode("\n", $content);

        return new News(
            id: NewsId::create(),
            title: new NewsTitle($title),
            content: new NewsContent($content),
            author: new newsAuthor($author),
            date: new \DateTimeImmutable($rawDate),
            source: $source,
            createdAt: new \DateTimeImmutable(),
            updatedAt: null,
            deletedAt: null
        );
    }
}
