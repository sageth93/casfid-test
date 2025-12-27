<?php

namespace App\Casfid\Feed\Application\News\Command\AddNews;

use App\Casfid\Feed\Domain\Model\Exception\NewsAlreadyExistsException;
use App\Casfid\Feed\Domain\Model\NewsCreatorInterface;
use App\Casfid\Feed\Domain\Model\NewsRepositoryInterface;
use App\Shared\Domain\Bus\Command\CommandHandler;

class AddNewsCommandHandler implements CommandHandler
{
    public function __construct(
        protected readonly NewsRepositoryInterface $newsRepository,
        protected readonly NewsCreatorInterface $newsCreator
    ){
    }

    public function handle(AddNewsCommand $command): void
    {
        $existingNews = $this->newsRepository->findById($command->id());

        if($existingNews)
        {
            throw NewsAlreadyExistsException::create($command->id());
        }

        $this->newsCreator->add(
            id: $command->id(),
            title: $command->title(),
            content: $command->content(),
            author: $command->author(),
            date: $command->date()
        );
    }
}
