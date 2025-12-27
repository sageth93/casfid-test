<?php

namespace App\Casfid\Scraper\Infrastructure\Persistence\Doctrine\DBAL\Types\News;

use App\Casfid\Scraper\Domain\News\Model\ValueObject\NewsId;
use App\Shared\Infrastructure\Persistence\Doctrine\DBAL\Types\UuidType;

class NewsIdType extends UuidType
{

    public static function customTypeName(): string
    {
        return 'NewsId';
    }

    protected function typeClassName(): string
    {
        return NewsId::class;
    }
}
