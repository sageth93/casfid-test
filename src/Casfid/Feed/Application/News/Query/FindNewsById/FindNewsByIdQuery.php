<?php

namespace App\Casfid\Feed\Application\News\Query\FindNewsById;

use App\Shared\Domain\Bus\Query\Query;

class FindNewsByIdQuery implements Query
{
    public function __construct(
        protected readonly string $id
    )
    {
    }

    public function id(): string
    {
        return $this->id;
    }
}
