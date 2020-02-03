<?php

namespace App\Repository;

use App\Entity\ParticipationLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ParticipationLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParticipationLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParticipationLike[]    findAll()
 * @method ParticipationLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipationLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParticipationLike::class);
    }

    // /**
    //  * @return ParticipationLike[] Returns an array of ParticipationLike objects
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
    public function findOneBySomeField($value): ?ParticipationLike
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
