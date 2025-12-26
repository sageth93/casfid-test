<?php

namespace App\Shared\Infrastructure\Middleware;

use Doctrine\ORM\EntityManagerInterface;
use League\Tactician\Middleware;

class DoctrineFlushMiddleware implements Middleware
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function execute($command, callable $next)
    {
        $result = $next($command);
        $this->entityManager->flush();

        return $result;
    }
}
