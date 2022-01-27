<?php

namespace App\Repository;

use App\Entity\PublishedSubmission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PublishedSubmission|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublishedSubmission|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublishedSubmission[]    findAll()
 * @method PublishedSubmission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublishedSubmissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublishedSubmission::class);
    }

    // /**
    //  * @return PublishedSubmission[] Returns an array of PublishedSubmission objects
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
    public function findOneBySomeField($value): ?PublishedSubmission
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
