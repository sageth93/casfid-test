<?php

namespace App\Casfid\Scraper\Domain\News\Model;

use App\Casfid\Scraper\Domain\News\Model\ValueObject\NewsAuthor;
use App\Casfid\Scraper\Domain\News\Model\ValueObject\NewsContent;
use App\Casfid\Scraper\Domain\News\Model\ValueObject\NewsId;
use App\Casfid\Scraper\Domain\News\Model\ValueObject\NewsTitle;
use App\Casfid\Scraper\Domain\Source\Model\Source;

class News
{
    public function __construct(
        protected NewsId              $id,
        protected NewsTitle           $title,
        protected NewsContent         $content,
        protected NewsAuthor          $author,
        protected \DateTimeImmutable  $date,
        protected Source              $source,
        protected \DateTimeImmutable  $createdAt,
        protected ?\DateTimeImmutable $updatedAt,
        protected ?\DateTimeImmutable $deletedAt
    )
    {
    }

    public function id(): NewsId
    {
        return $this->id;
    }

    public function title(): NewsTitle
    {
        return $this->title;
    }

    public function content(): NewsContent
    {
        return $this->content;
    }

    public function author(): NewsAuthor
    {
        return $this->author;
    }

    public function date(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function source(): Source
    {
        return $this->source;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }
}
