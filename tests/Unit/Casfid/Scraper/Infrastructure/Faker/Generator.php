<?php

namespace App\Tests\Unit\Casfid\Scraper\Infrastructure\Faker;

use App\Casfid\Scraper\Domain\Source\Model\Source;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceHash;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceId;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceUrl;
use DateTimeInterface;

/**
 * @method Source source(?SourceId $id = null,?SourceUrl $url = null,?SourceOrigin $origin = null,?SourceHash $hash = null,?DateTimeInterface $createdAt = null,?DateTimeInterface $updatedAt = null,?DateTimeInterface $deletedAt = null,?bool $pending = null)
 */
class Generator extends \Faker\Generator
{

}
