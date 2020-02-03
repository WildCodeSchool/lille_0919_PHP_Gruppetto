<?php

namespace App\Repository;

use App\Entity\SportCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SportCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method SportCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method SportCategory[]    findAll()
 * @method SportCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SportCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SportCategory::class);
    }

    // /**
    //  * @return SportCategory[] Returns an array of SportCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SportCategory
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
