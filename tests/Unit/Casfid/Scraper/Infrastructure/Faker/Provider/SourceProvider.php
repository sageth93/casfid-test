<?php

namespace App\Tests\Unit\Casfid\Scraper\Infrastructure\Faker\Provider;

use App\Casfid\Scraper\Domain\Source\Model\Source;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceHash;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceId;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceUrl;
use DateTimeInterface;

class SourceProvider extends Provider
{
    public function source(
        ?SourceId $id = null,
        ?SourceUrl $url = null,
        ?SourceOrigin $origin = null,
        ?SourceHash $hash = null,
        ?DateTimeInterface $createdAt = null,
        ?DateTimeInterface $updatedAt = null,
        ?DateTimeInterface $deletedAt = null,
        ?bool $pending = null
    ): Source
    {
        $fakerUrl = 'https://www.elpais.com/elpais/2022/01/24/actualidad/1643022293_302577.html';
        return new Source(
            id: $id ?? SourceId::create(),
            url: $url ?? new SourceUrl($fakerUrl),
            origin: $origin ?? SourceOrigin::EL_PAIS,
            hash: $hash ?? new SourceHash($fakerUrl),
            createdAt: $createdAt ?? new \DateTimeImmutable(),
            updatedAt: $updatedAt ?? null,
            deletedAt: $deletedAt ?? null,
            pending: $pending ?? true
        );
    }
}
