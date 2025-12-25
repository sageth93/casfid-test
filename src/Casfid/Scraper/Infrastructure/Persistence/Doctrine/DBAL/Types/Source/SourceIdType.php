<?php

namespace App\Casfid\Scraper\Infrastructure\Persistence\Doctrine\DBAL\Types\Source;

use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceId;
use App\Shared\Infrastructure\Persistence\Doctrine\DBAL\Types\UuidType;

class SourceIdType extends UuidType
{

    public static function customTypeName(): string
    {
        return 'SourceId';
    }

    protected function typeClassName(): string
    {
        return SourceId::class;
    }
}
