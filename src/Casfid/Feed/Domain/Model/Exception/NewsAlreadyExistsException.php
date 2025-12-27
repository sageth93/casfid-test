<?php

namespace App\Casfid\Feed\Domain\Model\Exception;

class NewsAlreadyExistsException extends \RuntimeException
{
    public static function create(string $id): self
    {
        return new self(sprintf('News with id "%s" already exists', $id));
    }
}
