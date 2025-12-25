<?php

namespace App\Casfid\Scraper\Domain\Source\Model;

use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceHash;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceId;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceUrl;
use DateTimeInterface;

class Source
{
    public function __construct(
        public readonly SourceId $id,
        public readonly SourceUrl $url,
        public readonly SourceOrigin $origin,
        public readonly SourceHash $hash,
        public readonly DateTimeInterface $createdAt,
        public ?DateTimeInterface $updatedAt,
        public ?DateTimeInterface $deletedAt,
        public bool $pending
    )
    {
    }

    public static function create(
        SourceUrl $url,
        SourceOrigin $origin,
    ): self
    {
        return new self(
            id: SourceId::create(),
            url: $url,
            origin: $origin,
            hash: new SourceHash($url->value()),
            createdAt: new \DateTimeImmutable(),
            updatedAt: null,
            deletedAt: null,
            pending: true
        );
    }

    public function scrapDone(): void
    {
        $this->pending = false;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function isPending(): bool
    {
        return $this->pending;
    }
}
