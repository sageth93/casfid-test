<?php

namespace App\Casfid\Feed\Domain\Services;

use App\Casfid\Feed\Domain\Model\News;
use App\Casfid\Feed\Domain\Model\NewsCreatorInterface;
use App\Casfid\Feed\Domain\Model\NewsRepositoryInterface;
use App\Shared\Domain\Model\ValueObject\UuidValueObject;

class NewsCreator implements NewsCreatorInterface
{
    public function __construct(
        protected readonly NewsRepositoryInterface $newsRepository
    )
    {

    }
    public function add(
        string $title,
        string $content,
        string $author,
        ?\DateTimeInterface $date
    ): void
    {
        $news = News::create(
            id: UuidValueObject::create(),
            title: $title,
            content: $content,
            author: $author,
            date: $date ? \DateTimeImmutable::createFromInterface($date) : new \DateTimeImmutable(),
        );

        $this->newsRepository->save($news);
    }
}
