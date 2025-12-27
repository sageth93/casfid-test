<?php

namespace App\Casfid\Scraper\Infrastructure\Persistence\Doctrine\DBAL\Types\News;

use App\Casfid\Scraper\Domain\News\Model\ValueObject\NewsAuthor;
use App\Shared\Infrastructure\Persistence\Doctrine\DBAL\Types\CustomStringType;

class NewsAuthorType extends CustomStringType
{

    protected function typeClassName(): string
    {
        return NewsAuthor::class;
    }

    public static function customTypeName(): string
    {
        return 'NewsAuthor';
    }
}
