<?php

namespace App\Casfid\Feed\Infrastructure\Persistence\Fixtures;

use App\Casfid\Feed\Domain\Model\News;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NewsFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $fixtures = [
            new News(
                id: '019b62be-ccd1-7ae3-883b-c085ef77458a',
                title: 'Noticia de prueba 1',
                content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                author: 'David Tennant',
                date: new \DateTimeImmutable('2025-12-28 09:30:00'),
                createdAt: new \DateTimeImmutable('2025-12-28 09:30:00'),
                updatedAt: null,
                deletedAt: null
            ),
            new News(
                id: '019b62bf-36d3-7343-8cec-4f69c4ce1350',
                title: 'Noticia de prueba 2',
                content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                author: 'Peter Capaldi',
                date: new \DateTimeImmutable('2025-12-28 09:30:00'),
                createdAt: new \DateTimeImmutable('2025-12-28 09:30:00'),
                updatedAt: null,
                deletedAt: null
            ),
            new News(
                id: '019b62bf-4dc2-7cd6-b46f-d53b69f83e59',
                title: 'Noticia de prueba 3',
                content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                author: 'Matt Smith',
                date: new \DateTimeImmutable('2025-12-28 09:30:00'),
                createdAt: new \DateTimeImmutable('2025-12-28 09:30:00'),
                updatedAt: null,
                deletedAt: null
            )
        ];

        foreach ($fixtures as $fixture) {
            $manager->persist($fixture);
        }

        $manager->flush();
    }
}
