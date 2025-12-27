<?php

namespace App\Casfid\Scraper\Infrastructure\Persistence\Doctrine\ORM;

use App\Casfid\Scraper\Domain\News\Model\News;
use App\Casfid\Scraper\Domain\News\Model\NewsRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository implements NewsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function save(News $news): void
    {
        $this->getEntityManager()->persist($news);
    }
}
