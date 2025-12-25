<?php

namespace App\Casfid\Scraper\Infrastructure\Persistence\Doctrine\ORM;

use App\Casfid\Scraper\Domain\Source\Model\Source;
use App\Casfid\Scraper\Domain\Source\Model\SourceRepositoryInterface;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceHash;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceId;

class SourceRepository implements SourceRepositoryInterface
{

    public function find(SourceId $id): ?Source
    {
        // TODO: Implement find() method.
    }

    public function save(Source $source): void
    {
        // TODO: Implement save() method.
    }

    public function findRemaining(): array
    {
        // TODO: Implement findRemaining() method.
    }

    public function sourceExists(SourceHash $url): bool
    {
        // TODO: Implement sourceExists() method.
    }
}
