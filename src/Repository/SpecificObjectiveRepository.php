<?php

namespace App\Repository;

use App\Entity\SpecificObjective;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SpecificObjective|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecificObjective|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecificObjective[]    findAll()
 * @method SpecificObjective[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecificObjectiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecificObjective::class);
    }

    // /**
    //  * @return SpecificObjective[] Returns an array of SpecificObjective objects
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
    public function findOneBySomeField($value): ?SpecificObjective
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
