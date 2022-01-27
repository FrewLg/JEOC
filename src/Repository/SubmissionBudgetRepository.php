<?php

namespace App\Repository;

use App\Entity\SubmissionBudget;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubmissionBudget|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubmissionBudget|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubmissionBudget[]    findAll()
 * @method SubmissionBudget[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubmissionBudgetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubmissionBudget::class);
    }

    // /**
    //  * @return SubmissionBudget[] Returns an array of SubmissionBudget objects
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
    public function findOneBySomeField($value): ?SubmissionBudget
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
