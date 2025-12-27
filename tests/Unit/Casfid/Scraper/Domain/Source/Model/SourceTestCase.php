<?php

namespace App\Tests\Unit\Casfid\Scraper\Domain\Source\Model;

use App\Casfid\Scraper\Domain\Source\Model\SourceScraperInterface;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;
use App\Tests\Unit\Casfid\Scraper\Infrastructure\Faker\Factory;
use App\Tests\Unit\Casfid\Scraper\Infrastructure\Faker\Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SourceTestCase extends TestCase
{
    public ?Generator $faker = null;

    public function setUp(): void {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function createSourceScraper(SourceOrigin $origin): MockObject|SourceScraperInterface {
        $mock = $this->getMockBuilder(SourceScraperInterface::class)->getMock();

        $mock->method('origin')->willReturn($origin);

        return $mock;
    }
}
