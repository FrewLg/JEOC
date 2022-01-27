<?php

namespace App\Repository;

use App\Entity\ReviewAssignment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReviewAssignment|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReviewAssignment|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReviewAssignment[]    findAll()
 * @method ReviewAssignment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewAssignmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReviewAssignment::class);
    }

    // /**
    //  * @return ReviewAssignment[] Returns an array of ReviewAssignment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReviewAssignment
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
