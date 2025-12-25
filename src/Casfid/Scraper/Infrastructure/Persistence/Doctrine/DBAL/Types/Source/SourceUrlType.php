<?php

namespace App\Casfid\Scraper\Infrastructure\Persistence\Doctrine\DBAL\Types\Source;

use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceUrl;
use App\Shared\Infrastructure\Persistence\Doctrine\DBAL\Types\CustomStringType;

class SourceUrlType extends CustomStringType
{

    protected function typeClassName(): string
    {
        return SourceUrl::class;
    }

    public static function customTypeName(): string
    {
        return 'SourceUrl';
    }
}
