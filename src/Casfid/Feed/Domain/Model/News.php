<?php

namespace App\Casfid\Feed\Domain\Model;

class News
{
    public function __construct(
        protected string $id,
        protected string $title,
        protected string $content,
        protected string $author,
        protected \DateTimeImmutable $date,
        protected \DateTimeImmutable $createdAt,
        protected ?\DateTimeImmutable $updatedAt,
        protected ?\DateTimeImmutable $deletedAt
    )
    {
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

    public function date(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
