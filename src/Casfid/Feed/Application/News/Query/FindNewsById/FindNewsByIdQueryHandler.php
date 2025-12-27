<?php

namespace App\Casfid\Feed\Application\News\Query\FindNewsById;

use App\Casfid\Feed\Application\News\Response\NewsResponse;
use App\Casfid\Feed\Domain\Model\NewsFinderInterface;
use App\Shared\Domain\Bus\Query\QueryHandler;
use App\Shared\Domain\Bus\Query\Response;

class FindNewsByIdQueryHandler implements QueryHandler
{
    public function __construct(
        protected readonly NewsFinderInterface $newsFinder
    )
    {
    }

    public function handle(FindNewsByIdQuery $query): Response
    {
        return NewsResponse::from($this->newsFinder->findById($query->id()));
    }
}
