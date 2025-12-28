<?php

namespace App\Casfid\Feed\Application\News\Command\AddNews;

use App\Casfid\Feed\Domain\Model\NewsCreatorInterface;
use App\Shared\Domain\Bus\Command\CommandHandler;

class AddNewsCommandHandler implements CommandHandler
{
    public function __construct(
        protected readonly NewsCreatorInterface $newsCreator
    ){
    }

    public function handle(AddNewsCommand $command): void
    {
        $this->newsCreator->add(
            title: $command->title(),
            content: $command->content(),
            author: $command->author(),
            date: $command->date()
        );
    }
}
