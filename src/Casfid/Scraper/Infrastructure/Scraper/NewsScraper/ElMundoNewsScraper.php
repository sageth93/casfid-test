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

class ElMundoNewsScraper extends BaseScraper implements NewsScraperInterface
{

    public function origin(): SourceOrigin
    {
        return SourceOrigin::EL_MUNDO;
    }

    public function scrap(Source $source): News
    {
        $crawler = $this->getCrawler($source->url());

        $article = $crawler->filter('article.ue-c-article')->first();

        $title = trim($article->filter('h1')->text());
        $articleBody = $article->filter('div[data-section=articleBody]')->first();
        $authorsList = $articleBody->filter('div.ue-c-article__author-name-item')
            ->each(
                function ($node) {
                    if($node->filter('a')->count()) {
                        return trim($node->filter('a')->text());
                    }

                    return trim(
                        $node->text()
                    );
                }
            );
        $author = implode(', ', $authorsList);
        $rawDate = $articleBody->filter('div.ue-c-article__publishdate time')->first()->attr('datetime');

        $content = $articleBody->filter('div[data-section=articleBody] p')
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
