<?php

namespace App\Shared\Infrastructure\Controller;

use App\Shared\Domain\Bus\Command\Command;
use App\Shared\Domain\Bus\Query\Query;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    public function __construct(protected readonly CommandBus $commandBus)
    {

    }

    protected function handle(Command|Query $command): mixed
    {
        return $this->commandBus->handle($command);
    }
}
