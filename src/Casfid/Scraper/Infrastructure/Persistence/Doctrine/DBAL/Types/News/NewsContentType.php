<?php

namespace App\Casfid\Scraper\Infrastructure\Persistence\Doctrine\DBAL\Types\News;

use App\Casfid\Scraper\Domain\News\Model\ValueObject\NewsContent;
use App\Shared\Infrastructure\Persistence\Doctrine\DBAL\Types\CustomTextType;

class NewsContentType extends CustomTextType
{

    protected function typeClassName(): string
    {
        return NewsContent::class;
    }

    public static function customTypeName(): string
    {
        return 'NewsContent';
    }
}
