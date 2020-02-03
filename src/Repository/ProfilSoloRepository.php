<?php

namespace App\Repository;

use App\Entity\ProfilSolo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProfilSolo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfilSolo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfilSolo[]    findAll()
 * @method ProfilSolo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfilSoloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfilSolo::class);
    }

    // /**
    //  * @return ProfilSolo[] Returns an array of ProfilSolo objects
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
    public function findOneBySomeField($value): ?ProfilSolo
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
