<?php

namespace App\Repository;

use App\Entity\SubmissionStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubmissionStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubmissionStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubmissionStatus[]    findAll()
 * @method SubmissionStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubmissionStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubmissionStatus::class);
    }

    // /**
    //  * @return SubmissionStatus[] Returns an array of SubmissionStatus objects
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
    public function findOneBySomeField($value): ?SubmissionStatus
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
