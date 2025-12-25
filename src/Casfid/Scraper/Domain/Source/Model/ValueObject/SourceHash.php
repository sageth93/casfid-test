<?php

namespace App\Casfid\Scraper\Domain\Source\Model\ValueObject;

use App\Shared\Domain\Model\ValueObject\StringValueObject;

class SourceHash extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct(hash('sha256', $value));
    }
}
