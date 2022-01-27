<?php

namespace App\Repository;

use App\Entity\WorkUnit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkUnit|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkUnit|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkUnit[]    findAll()
 * @method WorkUnit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkUnitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkUnit::class);
    }

    // /**
    //  * @return WorkUnit[] Returns an array of WorkUnit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WorkUnit
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
