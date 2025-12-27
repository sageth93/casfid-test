<?php

namespace App\Casfid\Feed\Application\News\Command\UpdateNews;

use App\Casfid\Feed\Domain\Model\NewsUpdaterInterface;
use App\Shared\Domain\Bus\Command\CommandHandler;

class UpdateNewsCommandHandler implements CommandHandler
{
    public function __construct(
        protected readonly NewsUpdaterInterface $newsUpdater
    ){
    }

    public function handle(UpdateNewsCommand $command): void
    {
        $this->newsUpdater->update(
            id: $command->id(),
            title: $command->title(),
            content: $command->content(),
            author: $command->author(),
            date: $command->date()
        );
    }
}
