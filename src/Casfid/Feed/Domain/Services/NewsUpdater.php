<?php

namespace App\Casfid\Feed\Domain\Services;

use App\Casfid\Feed\Domain\Model\Exception\NewsNotFoundException;
use App\Casfid\Feed\Domain\Model\Exception\NewsNotModifiedException;
use App\Casfid\Feed\Domain\Model\NewsRepositoryInterface;
use App\Casfid\Feed\Domain\Model\NewsUpdaterInterface;

class NewsUpdater implements NewsUpdaterInterface
{
    public function __construct(
        protected readonly NewsRepositoryInterface $newsRepository
    )
    {

    }
    public function update(
        string $id,
        ?string $title,
        ?string $content,
        ?string $author,
        ?\DateTimeInterface $date
    ): void
    {
        $news = $this->newsRepository->findById($id);

        if(!$news) {
            throw NewsNotFoundException::create($id);
        }

        if(
            ($title && $title !== $news->title()) ||
            ($content && $content !== $news->content()) ||
            ($author && $author !== $news->author()) ||
            ($date && $date->getTimestamp() !== $news->date()->getTimestamp())
        ) {
            $news->update(
                title: $title,
                content: $content,
                author: $author,
                date: $date ? \DateTimeImmutable::createFromInterface($date) : null
            );

            $this->newsRepository->save($news);
            return;
        }

        throw NewsNotModifiedException::create($id);
    }
}
