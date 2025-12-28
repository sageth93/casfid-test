<?php

namespace App\Casfid\Scraper\Infrastructure\Scraper\NewsScraper;

use App\Casfid\Scraper\Domain\News\Model\News;
use App\Casfid\Scraper\Domain\Source\Model\Source;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;
use App\Casfid\Scraper\Infrastructure\Scraper\Base\BaseNewsScraper;
use App\Casfid\Scraper\Infrastructure\Scraper\Model\ScraperMainContentMissingException;

class ElMundoNewsScraper extends BaseNewsScraper
{

    public function origin(): SourceOrigin
    {
        return SourceOrigin::EL_MUNDO;
    }

    public function scrap(Source $source): News
    {
        $crawler = $this->getCrawler($source->url());

        if ($crawler->filter('article.ue-c-article')->count() === 0) {
            throw ScraperMainContentMissingException::create(self::class, $source->url());
        }

        $article = $crawler->filter('article.ue-c-article')->first();

        $title = $this->text($article, 'h1');

        if ($crawler->filter('div[data-section=articleBody]')->count() === 0) {
            throw ScraperMainContentMissingException::create(self::class, $source->url());
        }

        $articleBody = $article->filter('div[data-section=articleBody]')->first();
        $authorsList = $articleBody->filter('div.ue-c-article__author-name-item')
            ->each(function ($node) {
                return $node->filter('a')->count()
                    ? $this->text($node, 'a')
                    : $this->text($node, '');
            });

        $dateStr = $this->attr($articleBody, 'div.ue-c-article__publishdate time', 'datetime');
        $content = $this->list($articleBody, 'div[data-section=articleBody] p');

        return $this->createNews(
            source: $source,
            title: $title,
            content: $content,
            authors: $authorsList,
            rawDate: $dateStr
        );
    }
}
