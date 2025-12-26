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
        protected readonly SourceId $id,
        protected readonly SourceUrl $url,
        protected readonly SourceOrigin $origin,
        protected readonly SourceHash $hash,
        protected readonly DateTimeInterface $createdAt,
        protected ?DateTimeInterface $updatedAt,
        protected ?DateTimeInterface $deletedAt,
        protected bool $pending
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

    public function id(): SourceId
    {
        return $this->id;
    }

    public function url(): SourceUrl
    {
        return $this->url;
    }

    public function origin(): SourceOrigin
    {
        return $this->origin;
    }

    public function hash(): SourceHash
    {
        return $this->hash;
    }

    public function createdAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function isPending(): bool
    {
        return $this->pending;
    }

    public function scrapDone(): void
    {
        $this->pending = false;
        $this->updatedAt = new \DateTimeImmutable();
    }
}
