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

    public static function create(
        string $id,
        string $title,
        string $content,
        string $author,
        ?\DateTimeImmutable $date
    ): self
    {
        return new self(
            id: $id,
            title: $title,
            content: $content,
            author: $author,
            date: $date ?? null,
            createdAt: new \DateTimeImmutable(),
            updatedAt: null,
            deletedAt: null
        );
    }

    public function update(
        string $title,
        string $content,
        string $author,
        \DateTimeImmutable $date
    ): void {
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->date = $date;

        $this->updatedAt = new \DateTimeImmutable();
    }

    public function delete(): void
    {
        $this->deletedAt = new \DateTimeImmutable();
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
