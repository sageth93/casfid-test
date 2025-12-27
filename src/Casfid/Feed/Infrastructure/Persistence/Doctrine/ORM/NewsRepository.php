<?php

namespace App\Casfid\Feed\Infrastructure\Persistence\Doctrine\ORM;

use App\Casfid\Feed\Domain\Model\News;
use App\Casfid\Feed\Domain\Model\NewsRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository implements NewsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }
    public function findById(string $id): ?News
    {
        return $this->createQueryBuilder('n')
            ->where('n.id = :id')
            ->setParameter('id', $id)
            ->andWhere('n.deletedAt IS NULL')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAll(): array {
        return $this->createQueryBuilder('c')
            ->where('c.deletedAt IS NULL')
            ->orderBy('c.date', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
