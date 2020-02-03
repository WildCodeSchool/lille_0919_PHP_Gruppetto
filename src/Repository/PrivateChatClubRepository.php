<?php

namespace App\Repository;

use App\Entity\PrivateChatClub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PrivateChatClub|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrivateChatClub|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrivateChatClub[]    findAll()
 * @method PrivateChatClub[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrivateChatClubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrivateChatClub::class);
    }

    // /**
    //  * @return PrivateChatClub[] Returns an array of PrivateChatClub objects
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
    public function findOneBySomeField($value): ?PrivateChatClub
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
