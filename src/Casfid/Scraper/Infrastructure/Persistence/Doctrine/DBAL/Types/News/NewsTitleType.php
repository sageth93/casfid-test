<?php

namespace App\Casfid\Scraper\Infrastructure\Persistence\Doctrine\DBAL\Types\News;

use App\Casfid\Scraper\Domain\News\Model\ValueObject\NewsTitle;
use App\Shared\Infrastructure\Persistence\Doctrine\DBAL\Types\CustomStringType;

class NewsTitleType extends CustomStringType
{

    protected function typeClassName(): string
    {
        return NewsTitle::class;
    }

    public static function customTypeName(): string
    {
        return 'NewsTitle';
    }
}
