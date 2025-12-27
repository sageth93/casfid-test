<?php

namespace App\Casfid\Feed\Domain\Model;

interface NewsRepositoryInterface
{
    public function findById(string $id): ?News;

    /** @return News[] */
    public function findAll(): array;
}
