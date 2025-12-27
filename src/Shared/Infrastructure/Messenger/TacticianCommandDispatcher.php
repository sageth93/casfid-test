<?php

namespace App\Shared\Infrastructure\Messenger;

use App\Shared\Domain\Bus\Command\Command;
use League\Tactician\CommandBus;

class TacticianCommandDispatcher
{
    public function __construct(
        private CommandBus $commandBus
    )
    {
    }

    public function __invoke(Command $command)
    {
        $this->commandBus->handle($command);
    }
}

