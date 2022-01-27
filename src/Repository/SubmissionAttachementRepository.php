<?php

namespace App\Repository;

use App\Entity\SubmissionAttachement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubmissionAttachement|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubmissionAttachement|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubmissionAttachement[]    findAll()
 * @method SubmissionAttachement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubmissionAttachementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubmissionAttachement::class);
    }

    // /**
    //  * @return SubmissionAttachement[] Returns an array of SubmissionAttachement objects
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
    public function findOneBySomeField($value): ?SubmissionAttachement
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
