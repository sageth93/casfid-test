<?php

namespace App\Casfid\Scraper\Infrastructure\Scraper\NewsScraper;

use App\Casfid\Scraper\Domain\News\Model\News;
use App\Casfid\Scraper\Domain\Source\Model\Source;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;
use App\Casfid\Scraper\Infrastructure\Scraper\Base\BaseNewsScraper;
use App\Casfid\Scraper\Infrastructure\Scraper\Model\ScraperMainContentMissing;

class ElPaisNewsScraper extends BaseNewsScraper
{

    public function origin(): SourceOrigin
    {
        return SourceOrigin::EL_PAIS;
    }

    public function scrap(Source $source): News
    {
        $crawler = $this->getCrawler($source->url());

        if ($crawler->filter('article#main-content')->count() === 0) {
            throw ScraperMainContentMissing::create(self::class, $source->url());
        }

        $article = $crawler->filter('article#main-content')->first();

        $title = $this->text($article, 'header h1');
        $authors = $this->list($article, 'div[data-dtm-region=articulo_firma] a');
        $dateStr = $this->attr($article, 'time', 'datetime');
        $content = $this->list($article, 'div[data-dtm-region=articulo_cuerpo] p');

        return $this->createNews(
            source: $source,
            title: $title,
            content: $content,
            authors: $authors,
            rawDate: $dateStr
        );
    }
}
