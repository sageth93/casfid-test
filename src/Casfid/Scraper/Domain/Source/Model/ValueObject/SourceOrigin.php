<?php

namespace App\Casfid\Scraper\Domain\Source\Model\ValueObject;

enum SourceOrigin: string
{
    case EL_PAIS = 'ELP';
    case EL_MUNDO = 'ELM';

    public function equals(SourceOrigin $other): bool
    {
        return $this->value === $other->value;
    }
}
