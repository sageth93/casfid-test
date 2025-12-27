<?php

namespace App\Casfid\Feed\Application\News\Command\DeleteNewsById;

use App\Shared\Domain\Bus\Command\Command;

class DeleteNewsByIdCommand implements Command
{
    public function __construct(
        protected readonly string $id
    ){
    }

    public function id(): string
    {
        return $this->id;
    }
}
