<?php

namespace App\Repository;

use App\Entity\KartItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KartItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method KartItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method KartItem[]    findAll()
 * @method KartItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KartItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KartItem::class);
    }

    // /**
    //  * @return KartItem[] Returns an array of KartItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KartItem
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
