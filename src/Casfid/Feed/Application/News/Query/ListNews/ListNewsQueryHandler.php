<?php

namespace App\Casfid\Feed\Application\News\Query\ListNews;

use App\Casfid\Feed\Application\News\Response\NewsResponse;
use App\Casfid\Feed\Domain\Model\NewsRepositoryInterface;
use App\Shared\Domain\Bus\Query\QueryHandler;

class ListNewsQueryHandler implements QueryHandler
{
    public function __construct(
        protected readonly NewsRepositoryInterface $newsRepository
    )
    {
    }

    public function handle(ListNewsQuery $query): array
    {
        return array_map(fn($news) => NewsResponse::from($news), $this->newsRepository->findAll());
    }
}
