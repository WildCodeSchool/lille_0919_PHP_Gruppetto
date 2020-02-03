<?php

namespace App\Repository;

use App\Entity\ProfilClub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProfilClub|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfilClub|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfilClub[]    findAll()
 * @method ProfilClub[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfilClubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfilClub::class);
    }

    // /**
    //  * @return ProfilClub[] Returns an array of ProfilClub objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProfilClub
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
