<?php

namespace App\Casfid\Feed\Domain\Model\Exception;

class NewsNotModifiedException extends \RuntimeException
{
    public static function create(string $id): self
    {
        return new self(sprintf('News with id "%s" was not modified', $id));
    }
}
