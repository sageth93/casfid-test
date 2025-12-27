<?php

namespace App\Casfid\Feed\Application\News\Response;

use App\Casfid\Feed\Domain\Model\News;
use App\Shared\Domain\Bus\Query\Response;

class NewsResponse implements Response, \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $content,
        public readonly string $author,
        public readonly string $date,
        public readonly ?string $createdAt,
        public readonly ?string $updatedAt,
    ) {}

    public static function from(News $news): self
    {
        return new self(
            $news->id(),
            $news->title(),
            $news->content(),
            $news->author(),
            $news->date()->format('Y-m-d'),
            $news->createdAt()?->format('Y-m-d H:i:s'),
            $news->updatedAt()?->format('Y-m-d H:i:s')
        );
    }

    /** @return array<string, string|null> */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
