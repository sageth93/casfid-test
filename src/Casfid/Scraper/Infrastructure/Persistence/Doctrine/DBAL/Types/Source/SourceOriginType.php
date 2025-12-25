<?php

namespace App\Casfid\Scraper\Infrastructure\Persistence\Doctrine\DBAL\Types\Source;

use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceOrigin;
use App\Shared\Infrastructure\Persistence\Doctrine\DBAL\Types\CustomStringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class SourceOriginType extends CustomStringType
{

    protected function typeClassName(): string
    {
        return SourceOrigin::class;
    }

    public static function customTypeName(): string
    {
        return 'SourceOrigin';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->value();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): SourceOrigin
    {
        return SourceOrigin::from($value);
    }
}
