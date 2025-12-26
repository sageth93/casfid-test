<?php

namespace App\Casfid\Scraper\Infrastructure\Persistence\Doctrine\ORM;

use App\Casfid\Scraper\Domain\Source\Model\Source;
use App\Casfid\Scraper\Domain\Source\Model\SourceRepositoryInterface;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceHash;
use App\Casfid\Scraper\Domain\Source\Model\ValueObject\SourceId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Source|null find($id, $lockMode = null, $lockVersion = null)
 * @method Source|null findOneBy(array $criteria, array $orderBy = null)
 * @method Source[]    findAll()
 * @method Source[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SourceRepository extends ServiceEntityRepository implements SourceRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Source::class);
    }

    public function findById(SourceId $id): ?Source
    {
        return parent::find($id);
    }
    public function save(Source $source): void
    {
        $this->getEntityManager()->persist($source);
    }

    public function findRemaining(): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.pending = true')
            ->orderBy('s.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function sourceExists(SourceHash $hash): bool
    {
        return (bool) $this->createQueryBuilder('s')
            ->select('1')
            ->where('s.hash = :hash')
            ->setParameter('hash', $hash)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
