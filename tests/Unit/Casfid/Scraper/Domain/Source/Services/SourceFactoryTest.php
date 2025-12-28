<?php

namespace App\Tests\Unit\Casfid\Scraper\Domain\Source\Services;

use App\Casfid\Scraper\Domain\Source\Model\Exceptions\InvalidSourceScraperConfigurationException;
use App\Casfid\Scraper\Domain\Source\Model\Source;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;
use App\Casfid\Scraper\Domain\Source\Services\SourceFactory;
use App\Tests\Unit\Casfid\Scraper\Domain\Source\Model\SourceTestCase;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;

#[AllowMockObjectsWithoutExpectations]
class SourceFactoryTest extends SourceTestCase
{
    public function test_givenSourceFactory_whenGetSources_thenReturnSourceArray()
    {
        $elPaisMock = $this->createSourceScraper(SourceOrigin::EL_PAIS);
        $elMundoMock = $this->createSourceScraper(SourceOrigin::EL_MUNDO);

        $elPaisMock->expects($this->once())->method('scrap')->willReturn([
            $this->faker->source(),
            $this->faker->source(),
            $this->faker->source(),
        ]);

        $elMundoMock->expects($this->once())->method('scrap')->willReturn([
            $this->faker->source(),
            $this->faker->source(),
        ]);

        $factory = new SourceFactory([
            $elPaisMock,
            $elMundoMock,
        ]);

        $sources = $factory->getSources(5);

        $this->assertIsArray($sources);
        $this->assertCount(5, $sources);
        foreach ($sources as $source) $this->assertInstanceOf(Source::class, $source);
    }

    public function test_givenSourceFactory_whenScrapersHaveSameOrigin_thenThrowException()
    {
        $this->expectException(InvalidSourceScraperConfigurationException::class);

        $factory = new SourceFactory([
            $this->createSourceScraper(SourceOrigin::EL_MUNDO),
            $this->createSourceScraper(SourceOrigin::EL_MUNDO),
        ]);

        $factory->getSources(5);
    }

    public function test_givenSourceFactory_whenScrapersHaveInvalidInterface_thenThrowException()
    {
        $this->expectException(InvalidSourceScraperConfigurationException::class);

        $factory = new SourceFactory([
            new class {},
            $this->createSourceScraper(SourceOrigin::EL_MUNDO),
        ]);

        $factory->getSources(5);
    }
}
