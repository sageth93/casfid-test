<?php

namespace App\Casfid\Scraper\Domain\Source\Model\Exceptions;

class InvalidSourceScraperConfigurationException extends  \RuntimeException
{
    public static function invalidInterface(string $class): self
    {
        return new self(sprintf('The class %s does not implement SourceScraperInterface', $class));
    }

    public static function invalidOrigin(string $class): self
    {
        return new self(sprintf('Scraper %s returned an invalid origin.', $class));
    }

    public static function duplicatedOrigin(string $class): self
    {
        return new self(sprintf('Scraper %s has duplicated origin', $class));
    }
}
