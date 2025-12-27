<?php

namespace App\Casfid\Feed\Domain\Services;

use App\Casfid\Feed\Domain\Model\Exception\NewsNotFoundException;
use App\Casfid\Feed\Domain\Model\News;
use App\Casfid\Feed\Domain\Model\NewsFinderInterface;
use App\Casfid\Feed\Domain\Model\NewsRepositoryInterface;

class NewsFinder implements NewsFinderInterface
{
    public function __construct(
        protected readonly NewsRepositoryInterface $newsRepository
    )
    {
    }
    public function findById(string $id): News
    {
        $news = $this->newsRepository->findById($id);

        if(!$news) {
            throw NewsNotFoundException::create($id);
        }

        return $news;
    }
}
