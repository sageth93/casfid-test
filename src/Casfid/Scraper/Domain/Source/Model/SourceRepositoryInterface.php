<?php

namespace App\Casfid\Scraper\Domain\Source\Model;

use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceId;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceHash;

interface SourceRepositoryInterface
{
    public function findById(SourceId $id): ?Source;
    public function save(Source $source): void;
    /** @return Source[] */
    public function findRemaining(): array;
    public function sourceExists(SourceHash $hash): bool;


}
