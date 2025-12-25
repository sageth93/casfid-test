<?php

namespace App\Casfid\Scraper\Infrastructure\Persistence\Doctrine\DBAL\Types\Source;

use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceHash;
use App\Shared\Infrastructure\Persistence\Doctrine\DBAL\Types\CustomStringType;

class SourceHashType extends CustomStringType
{

    protected function typeClassName(): string
    {
        return SourceHash::class;
    }

    public static function customTypeName(): string
    {
        return 'SourceHash';
    }
}
