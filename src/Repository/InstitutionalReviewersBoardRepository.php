<?php

namespace App\Repository;

use App\Entity\InstitutionalReviewersBoard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InstitutionalReviewersBoard|null find($id, $lockMode = null, $lockVersion = null)
 * @method InstitutionalReviewersBoard|null findOneBy(array $criteria, array $orderBy = null)
 * @method InstitutionalReviewersBoard[]    findAll()
 * @method InstitutionalReviewersBoard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstitutionalReviewersBoardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InstitutionalReviewersBoard::class);
    }

    // /**
    //  * @return InstitutionalReviewersBoard[] Returns an array of InstitutionalReviewersBoard objects
    //  */
     
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            
            ->setMaxResults(10)
            
            ->getQuery()
            ->getResult()
        ;
    }
   

    /*
    public function findOneBySomeField($value): ?InstitutionalReviewersBoard
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
