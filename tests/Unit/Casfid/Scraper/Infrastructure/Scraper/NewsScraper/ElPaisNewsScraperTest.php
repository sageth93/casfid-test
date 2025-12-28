<?php

namespace App\Tests\Unit\Casfid\Scraper\Infrastructure\Scraper\NewsScraper;

use App\Casfid\Scraper\Domain\Source\Model\Source;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceUrl;
use App\Casfid\Scraper\Infrastructure\Scraper\HtmlCrawlerFactory;
use App\Casfid\Scraper\Infrastructure\Scraper\Model\ScraperMainContentMissingException;
use App\Casfid\Scraper\Infrastructure\Scraper\Model\ScraperMissingFieldException;
use App\Casfid\Scraper\Infrastructure\Scraper\NewsScraper\ElPaisNewsScraper;
use App\Tests\Unit\Casfid\Scraper\Infrastructure\Html\FakeHttpHtmlClient;
use PHPUnit\Framework\TestCase;

class ElPaisNewsScraperTest extends TestCase
{
    public function test_GivenNewsScraper_WhenPageIsOk_ThenReturnNews()
    {
        $fixture = <<<HTML
        <article id="main-content">
            <header><h1>Título de prueba</h1></header>
            <div data-dtm-region="articulo_firma">
                <a>Juan Pérez</a>
            </div>
            <time datetime="2024-01-01T10:00:00Z"></time>
            <div data-dtm-region="articulo_cuerpo">
                <p>Contenido ejemplo 1.</p>
                <p>Contenido ejemplo 2.</p>
            </div>
        </article>
    HTML;
        $scraper = new ElPaisNewsScraper(
            new FakeHttpHtmlClient($fixture),
            new HtmlCrawlerFactory()
        );

        $source = Source::create(
            url: new SourceUrl("https://elpais.com/test"),
            origin: SourceOrigin::EL_PAIS
        );

        $news = $scraper->scrap($source);

        $this->assertNotEmpty($news->title()->value());
        $this->assertNotEmpty($news->content()->value());
        $this->assertNotEmpty($news->author()->value());
        $this->assertInstanceOf(\DateTimeImmutable::class, $news->date());

        $this->assertEquals(SourceOrigin::EL_PAIS, $news->source()->origin());
    }

    public function test_GivenNewsScraper_WhenTitleIsMissing_ThenThrowValidationException()
    {
        $this->expectException(ScraperMissingFieldException::class);
        $fixture = <<<HTML
        <article id="main-content">
            <div data-dtm-region="articulo_firma">
                <a>Juan Pérez</a>
            </div>
            <time datetime="2024-01-01T10:00:00Z"></time>
            <div data-dtm-region="articulo_cuerpo">
                <p>Contenido ejemplo 1.</p>
                <p>Contenido ejemplo 2.</p>
            </div>
        </article>
    HTML;

        $scraper = new ElPaisNewsScraper(
            new FakeHttpHtmlClient($fixture),
            new HtmlCrawlerFactory()
        );

        $source = Source::create(
            url: new SourceUrl("https://elpais.com/test"),
            origin: SourceOrigin::EL_PAIS
        );

        $scraper->scrap($source);
    }

    public function test_GivenNewsScraper_WhenContentIsMissing_ThenThrowValidationException()
    {
        $this->expectException(ScraperMissingFieldException::class);
        $fixture = <<<HTML
            <article id="main-content">
                <header><h1>Título de prueba</h1></header>
                <div data-dtm-region="articulo_firma">
                    <a>Juan Pérez</a>
                </div>
                <time datetime="2024-01-01T10:00:00Z"></time>
            </article>
        HTML;

        $scraper = new ElPaisNewsScraper(
            new FakeHttpHtmlClient($fixture),
            new HtmlCrawlerFactory()
        );

        $source = Source::create(
            url: new SourceUrl("https://elpais.com/test"),
            origin: SourceOrigin::EL_PAIS
        );

        $scraper->scrap($source);
    }

    public function test_GivenNewsScraper_WhenMainArticleIsMissing_ThenThrowMainContentException()
    {
        $this->expectException(ScraperMainContentMissingException::class);
        $fixture = <<<HTML
            <article id="bad-id">
                <header><h1>Título de prueba</h1></header>
                <div data-dtm-region="articulo_firma">
                    <a>Juan Pérez</a>
                </div>
                <time datetime="2024-01-01T10:00:00Z"></time>
                <div data-dtm-region="articulo_cuerpo">
                    <p>Contenido ejemplo 1.</p>
                    <p>Contenido ejemplo 2.</p>
                </div>
            </article>
        HTML;

        $scraper = new ElPaisNewsScraper(
            new FakeHttpHtmlClient($fixture),
            new HtmlCrawlerFactory()
        );

        $source = Source::create(
            url: new SourceUrl("https://elpais.com/test"),
            origin: SourceOrigin::EL_PAIS
        );

        $scraper->scrap($source);
    }

    public function test_GivenNewsScraper_WhenAuthorIsMissing_ThenReturnUnknownAuthor()
    {
        $fixture = <<<HTML
            <article id="main-content">
                <header><h1>Título de prueba</h1></header>
                <time datetime="2024-01-01T10:00:00Z"></time>
                <div data-dtm-region="articulo_cuerpo">
                    <p>Contenido ejemplo 1.</p>
                    <p>Contenido ejemplo 2.</p>
                </div>
            </article>
        HTML;

        $scraper = new ElPaisNewsScraper(
            new FakeHttpHtmlClient($fixture),
            new HtmlCrawlerFactory()
        );

        $source = Source::create(
            url: new SourceUrl("https://elpais.com/test"),
            origin: SourceOrigin::EL_PAIS
        );

        $news = $scraper->scrap($source);
        $this->assertSame("Unknown", $news->author()->value());
    }
}
