<?php

namespace App\Casfid\Feed\Application\News\Command\DeleteNewsById;

use App\Casfid\Feed\Domain\Model\NewsFinderInterface;
use App\Casfid\Feed\Domain\Model\NewsRepositoryInterface;
use App\Shared\Domain\Bus\Command\CommandHandler;

class DeleteNewsByIdCommandHandler implements CommandHandler
{
    public function __construct(
        protected readonly NewsFinderInterface $newsFinder,
        protected readonly NewsRepositoryInterface $newsRepository
    )
    {
    }

    public function handle(DeleteNewsByIdCommand $command)
    {
        $news = $this->newsFinder->findById($command->id());
        $news->delete();

        $this->newsRepository->save($news);
    }
}
