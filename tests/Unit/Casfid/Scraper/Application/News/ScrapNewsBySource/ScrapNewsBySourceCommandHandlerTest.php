<?php

namespace App\Tests\Unit\Casfid\Scraper\Application\News\ScrapNewsBySource;

use App\Casfid\Scraper\Application\News\Command\ScrapNewsBySource\ScrapNewsBySourceCommand;
use App\Casfid\Scraper\Application\News\Command\ScrapNewsBySource\ScrapNewsBySourceCommandHandler;
use App\Casfid\Scraper\Domain\News\Model\News;
use App\Casfid\Scraper\Domain\News\Model\NewsRepositoryInterface;
use App\Casfid\Scraper\Domain\News\Model\NewsScraperFactoryInterface;
use App\Casfid\Scraper\Domain\News\Model\NewsScraperInterface;
use App\Casfid\Scraper\Domain\Source\Model\Exceptions\SourceAlreadyBeenScrapedException;
use App\Casfid\Scraper\Domain\Source\Model\Exceptions\SourceNotFoundException;
use App\Casfid\Scraper\Domain\Source\Model\Source;
use App\Casfid\Scraper\Domain\Source\Model\SourceRepositoryInterface;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceUrl;
use App\Tests\Unit\Casfid\Scraper\Infrastructure\Faker\Factory;
use App\Tests\Unit\Casfid\Scraper\Infrastructure\Faker\Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ScrapNewsBySourceCommandHandlerTest extends TestCase
{
    protected MockObject|SourceRepositoryInterface $sourceRepository;
    protected MockObject|NewsRepositoryInterface $newsRepository;
    protected MockObject|NewsScraperFactoryInterface $scraperFactory;
    protected MockObject|NewsScraperInterface $scraper;
    protected ScrapNewsBySourceCommandHandler $handler;

    public ?Generator $faker = null;

    protected function setUp(): void
    {
        $this->sourceRepository = $this->createMock(SourceRepositoryInterface::class);
        $this->newsRepository = $this->createStub(NewsRepositoryInterface::class);
        $this->scraperFactory = $this->createStub(NewsScraperFactoryInterface::class);
        $this->scraper = $this->createStub(NewsScraperInterface::class);

        $this->faker = Factory::create();

        $this->handler = new ScrapNewsBySourceCommandHandler(
            $this->sourceRepository,
            $this->scraperFactory,
            $this->newsRepository
        );
    }

    public function test_GivenNewsHandler_WhenSourceNotFound_ThenThrowException()
    {
        $this->expectException(SourceNotFoundException::class);
        $this->sourceRepository
            ->expects($this->once())
            ->method('findById')
            ->willReturn(null);


        $this->handler->handle(
            new ScrapNewsBySourceCommand('019b660c-2345-746e-b60c-70a56ceb62c0')
        );
    }

    public function test_GivenNewsHandler_WhenSourceIsNotPending_ThenThrowException()
    {
        $source = $this->createMock(Source::class);
        $source->expects($this->once())
            ->method('isPending')
            ->willReturn(false);

        $this->sourceRepository
            ->expects($this->once())
            ->method('findById')
            ->willReturn($source);

        $this->expectException(SourceAlreadyBeenScrapedException::class);

        $this->handler->handle(
            new ScrapNewsBySourceCommand('019b660c-2345-746e-b60c-70a56ceb62c0')
        );
    }

    public function test_GivenNewsHandler_EverythingIsOk_ThenShouldSaveNews()
    {
        $source = $this->createConfiguredMock(Source::class, [
            'isPending' => true,
            'origin' => SourceOrigin::EL_PAIS,
            'url' => new SourceUrl('http://example.com')
        ]);

        $news = $this->createMock(News::class);

        $news->expects($this->once())
            ->method('source')
            ->willReturn($source);

        $this->sourceRepository
            ->expects($this->once())
            ->method('findById')
            ->willReturn($source);

        $this->scraperFactory
            ->method('getScraper')
            ->willReturn($this->scraper);

        $this->scraper
            ->method('scrap')
            ->with($source)
            ->willReturn($news);

        $source->expects($this->once())
            ->method('scrapDone');

        $this->newsRepository
            ->method('save')
            ->with($news);

        $this->handler->handle(
            new ScrapNewsBySourceCommand('019b660c-2345-746e-b60c-70a56ceb62c0')
        );
    }
}
