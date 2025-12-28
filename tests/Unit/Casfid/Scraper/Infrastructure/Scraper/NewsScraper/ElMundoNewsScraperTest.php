<?php

namespace App\Tests\Unit\Casfid\Scraper\Infrastructure\Scraper\NewsScraper;

use App\Casfid\Scraper\Domain\Source\Model\Source;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceUrl;
use App\Casfid\Scraper\Infrastructure\Scraper\HtmlCrawlerFactory;
use App\Casfid\Scraper\Infrastructure\Scraper\Model\ScraperMainContentMissingException;
use App\Casfid\Scraper\Infrastructure\Scraper\Model\ScraperMissingFieldException;
use App\Casfid\Scraper\Infrastructure\Scraper\NewsScraper\ElMundoNewsScraper;
use App\Tests\Unit\Casfid\Scraper\Infrastructure\Html\FakeHttpHtmlClient;
use PHPUnit\Framework\TestCase;

class ElMundoNewsScraperTest extends TestCase
{
    public function test_GivenNewsScraper_WhenPageIsOk_ThenReturnNews()
    {
        $fixture = <<<HTML
            <article class="ue-c-article">
                <h1>Título Mundo</h1>
                <div data-section="articleBody">
                    <div class="ue-c-article__author-name-item"><a>Laura López</a></div>
                    <div class="ue-c-article__publishdate"><time datetime="2024-02-01T12:00:00Z"></time></div>
                    <p>Párrafo 1</p>
                    <p>Párrafo 2</p>
                </div>
            </article>
        HTML;

        $scraper = new ElMundoNewsScraper(
            new FakeHttpHtmlClient($fixture),
            new HtmlCrawlerFactory()
        );

        $source = Source::create(
            url: new SourceUrl("https://elmundo.es/test"),
            origin: SourceOrigin::EL_MUNDO
        );

        $news = $scraper->scrap($source);

        $this->assertStringContainsString("Título Mundo", $news->title()->value());
        $this->assertStringContainsString("Párrafo", $news->content()->value());
        $this->assertSame("Laura López", $news->author()->value());
        $this->assertInstanceOf(\DateTimeImmutable::class, $news->date());
        $this->assertEquals(SourceOrigin::EL_MUNDO, $news->source()->origin());
    }

    public function test_GivenNewsScraper_WhenTitleIsMissing_ThenThrowValidationException()
    {
        $this->expectException(ScraperMissingFieldException::class);
        $fixture = <<<HTML
            <article class="ue-c-article">
                <div data-section="articleBody">
                    <div class="ue-c-article__author-name-item"><a>Laura López</a></div>
                    <div class="ue-c-article__publishdate"><time datetime="2024-02-01T12:00:00Z"></time></div>
                    <p>Párrafo 1</p>
                    <p>Párrafo 2</p>
                </div>
            </article>
        HTML;

        $scraper = new ElMundoNewsScraper(
            new FakeHttpHtmlClient($fixture),
            new HtmlCrawlerFactory()
        );

        $source = Source::create(
            url: new SourceUrl("https://elmundo.es/test"),
            origin: SourceOrigin::EL_MUNDO
        );

        $scraper->scrap($source);
    }

    public function test_GivenNewsScraper_WhenContentIsMissing_ThenThrowValidationException()
    {
        $this->expectException(ScraperMissingFieldException::class);
        $fixture = <<<HTML
            <article class="ue-c-article">
                <h1>Título Mundo</h1>
                <div data-section="articleBody">
                    <div class="ue-c-article__author-name-item"><a>Laura López</a></div>
                    <div class="ue-c-article__publishdate"><time datetime="2024-02-01T12:00:00Z"></time></div>
                </div>
            </article>
        HTML;

        $scraper = new ElMundoNewsScraper(
            new FakeHttpHtmlClient($fixture),
            new HtmlCrawlerFactory()
        );

        $source = Source::create(
            url: new SourceUrl("https://elmundo.es/test"),
            origin: SourceOrigin::EL_MUNDO
        );

        $scraper->scrap($source);
    }

    public function test_GivenNewsScraper_WhenMainArticleIsMissing_ThenThrowMainContentException()
    {
        $this->expectException(ScraperMainContentMissingException::class);
        $fixture = <<<HTML
            <article class="bad-class">
                <h1>Título Mundo</h1>
                <div data-section="articleBody">
                    <div class="ue-c-article__author-name-item"><a>Laura López</a></div>
                    <div class="ue-c-article__publishdate"><time datetime="2024-02-01T12:00:00Z"></time></div>
                    <p>Párrafo 1</p>
                    <p>Párrafo 2</p>
                </div>
            </article>
        HTML;

        $scraper = new ElMundoNewsScraper(
            new FakeHttpHtmlClient($fixture),
            new HtmlCrawlerFactory()
        );

        $source = Source::create(
            url: new SourceUrl("https://elmundo.es/test"),
            origin: SourceOrigin::EL_MUNDO
        );

        $scraper->scrap($source);
    }

    public function test_GivenNewsScraper_WhenAuthorIsMissing_ThenReturnUnknownAuthor()
    {
        $fixture = <<<HTML
            <article class="ue-c-article">
                <h1>Título Mundo</h1>
                <div data-section="articleBody">
                    <div class="ue-c-article__publishdate"><time datetime="2024-02-01T12:00:00Z"></time></div>
                    <p>Párrafo 1</p>
                    <p>Párrafo 2</p>
                </div>
            </article>
        HTML;

        $scraper = new ElMundoNewsScraper(
            new FakeHttpHtmlClient($fixture),
            new HtmlCrawlerFactory()
        );

        $source = Source::create(
            url: new SourceUrl("https://elmundo.es/test"),
            origin: SourceOrigin::EL_MUNDO
        );

        $news = $scraper->scrap($source);
        $this->assertSame("Unknown", $news->author()->value());
    }
}
