<?php

namespace App\Repository;

use App\Entity\GeneralChatClub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GeneralChatClub|null find($id, $lockMode = null, $lockVersion = null)
 * @method GeneralChatClub|null findOneBy(array $criteria, array $orderBy = null)
 * @method GeneralChatClub[]    findAll()
 * @method GeneralChatClub[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeneralChatClubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GeneralChatClub::class);
    }

    // /**
    //  * @return GeneralChatClub[] Returns an array of GeneralChatClub objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GeneralChatClub
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
