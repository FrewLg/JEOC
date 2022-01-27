<?php

namespace App\Repository;

use App\Entity\CallForTraining;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CallForTraining|null find($id, $lockMode = null, $lockVersion = null)
 * @method CallForTraining|null findOneBy(array $criteria, array $orderBy = null)
 * @method CallForTraining[]    findAll()
 * @method CallForTraining[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CallForTrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CallForTraining::class);
    }

    // /**
    //  * @return CallForTraining[] Returns an array of CallForTraining objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CallForTraining
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
