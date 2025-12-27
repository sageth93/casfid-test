<?php

namespace App\Tests\Unit\Casfid\Scraper\Application\Source\ScrapSources;

use App\Casfid\Scraper\Application\Source\ScrapSources\ScrapSourcesCommand;
use App\Casfid\Scraper\Application\Source\ScrapSources\ScrapSourcesCommandHandler;
use App\Casfid\Scraper\Domain\Source\Event\NewPendingSourceEvent;
use App\Casfid\Scraper\Domain\Source\Model\SourceFactoryInterface;
use App\Casfid\Scraper\Domain\Source\Model\SourceRepositoryInterface;
use App\Shared\Domain\Event\EventPublisherInterface;
use App\Tests\Unit\Casfid\Scraper\Domain\Source\Model\SourceTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class ScrapSourcesCommandHandlerTest extends SourceTestCase
{
    protected MockObject|SourceFactoryInterface $factory;
    protected MockObject|SourceRepositoryInterface $repository;
    protected MockObject|EventPublisherInterface $publisher;
    protected ScrapSourcesCommandHandler $handler;
    public function setUp(): void
    {
        parent::setUp();

        $this->factory = $this->createMock(SourceFactoryInterface::class);
        $this->repository = $this->createMock(SourceRepositoryInterface::class);
        $this->publisher = $this->createMock(EventPublisherInterface::class);

        $this->handler = new ScrapSourcesCommandHandler(
            $this->factory,
            $this->repository,
            $this->publisher
        );
    }

    public function test_givenSourcesHandler_whenNoSourcesFounded_thenDoNothing()
    {
        $this->factory->method('getSources')->willReturn([]);

        $this->repository->expects($this->never())->method('save');
        $this->publisher->expects($this->never())->method('publish');

        $result = $this->handler->handle(new ScrapSourcesCommand(5));
        $this->assertEquals(0, $result);
    }

    public function test_givenSourcesHandler_whenSourcesFounded_thenSaveSources()
    {
        $this->factory->method('getSources')->willReturn([
            $this->faker->source(),
            $this->faker->source(),
            $this->faker->source(),
            $this->faker->source(),
            $this->faker->source()
        ]);

        $this->repository->method('sourceExists')->willReturn(false);

        $this->repository->expects($this->exactly(5))->method('save');
        $this->publisher
            ->expects($this->exactly(5))
            ->method('publish')
            ->with($this->isInstanceOf(NewPendingSourceEvent::class));

        $result = $this->handler->handle(new ScrapSourcesCommand(5));
        $this->assertEquals(5, $result);
    }

    public function test_givenSourcesHandler_whenSourcesFounded_thenOnySaveNonDuplicatedSources()
    {
        $this->factory->method('getSources')->willReturn([
            $this->faker->source(),
            $this->faker->source(),
        ]);

        $this->repository->method('sourceExists')
            ->willReturnOnConsecutiveCalls(true, false);

        $this->repository->expects($this->exactly(1))->method('save');
        $this->publisher
            ->expects($this->exactly(1))
            ->method('publish')
            ->with($this->isInstanceOf(NewPendingSourceEvent::class));

        $result = $this->handler->handle(new ScrapSourcesCommand(5));
        $this->assertEquals(1, $result);
    }
}
