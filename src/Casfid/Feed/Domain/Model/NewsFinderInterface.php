<?php

namespace App\Casfid\Feed\Domain\Model;

interface NewsFinderInterface
{
    public function findById(string $id): News;
}
