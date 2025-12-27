<?php

namespace App\Casfid\Feed\Domain\Services;

use App\Casfid\Feed\Domain\Model\News;
use App\Casfid\Feed\Domain\Model\NewsCreatorInterface;
use App\Casfid\Feed\Domain\Model\NewsRepositoryInterface;

class NewsCreator implements NewsCreatorInterface
{
    public function __construct(
        protected readonly NewsRepositoryInterface $newsRepository
    )
    {

    }
    public function add(
        string $id,
        string $title,
        string $content,
        string $author,
        ?\DateTimeInterface $date
    ): void
    {
        $news = News::create(
            id: $id,
            title: $title,
            content: $content,
            author: $author,
            date: $date ? \DateTimeImmutable::createFromInterface($date) : new \DateTimeImmutable(),
        );

        $this->newsRepository->save($news);
    }
}
