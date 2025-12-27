<?php

namespace App\Casfid\Feed\Application\News\Command\AddNews;

use App\Shared\Domain\Bus\Command\Command;

class AddNewsCommand implements Command
{
    public function __construct(
        protected readonly string $id,
        protected readonly string $title,
        protected readonly string $content,
        protected readonly string $author,
        protected readonly \DateTimeInterface $date
    ){

    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function author(): string
    {
        return $this->author;
    }

    public function date(): \DateTimeInterface
    {
        return $this->date;
    }
}
