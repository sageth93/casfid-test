<?php

namespace App\Casfid\Scraper\Infrastructure\Scraper\SourceScraper;

use App\Casfid\Scraper\Domain\Source\Model\Source;
use App\Casfid\Scraper\Domain\Source\Model\SourceScraperInterface;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceUrl;
use App\Casfid\Scraper\Infrastructure\Scraper\Base\BaseScraper;
use App\Casfid\Scraper\Infrastructure\Scraper\Model\ScraperMainContentMissingException;

class ElMundoSourceScraper extends BaseScraper implements SourceScraperInterface
{
    public function origin(): SourceOrigin
    {
        return SourceOrigin::EL_MUNDO;
    }

    public function newsIndex(): string
    {
        return 'https://www.elmundo.es/';
    }

    public function scrap(int $limit): array
    {
        $crawler = $this->getCrawler($this->newsIndex());
        $sources = [];

        if($crawler->filter('article')->count() === 0) {
            throw ScraperMainContentMissingException::create(self::class, $this->newsIndex());
        }

        $crawler->filter('article')->each(function ($node) use (&$sources, $limit){
            if(count($sources) >= $limit) {
                return;
            }

            if(!$node->filter('header a')->count()) {
                return;
            }

            $link = $node->filter('header a')->link();

            if(!$link) {
                return;
            }

            $sources[] = Source::create(
                new SourceUrl($link->getUri()),
                $this->origin()
            );
        });

        return $sources;
    }
}
