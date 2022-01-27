<?php

namespace App\Repository;

use App\Entity\CollegeCoordinator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CollegeCoordinator|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollegeCoordinator|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollegeCoordinator[]    findAll()
 * @method CollegeCoordinator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollegeCoordinatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CollegeCoordinator::class);
    }

    // /**
    //  * @return CollegeCoordinator[] Returns an array of CollegeCoordinator objects
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
    public function findOneBySomeField($value): ?CollegeCoordinator
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
