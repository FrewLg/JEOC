<?php

namespace App\Repository;

use App\Entity\AcademicRank;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AcademicRank|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcademicRank|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcademicRank[]    findAll()
 * @method AcademicRank[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcademicRankRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AcademicRank::class);
    }

    // /**
    //  * @return AcademicRank[] Returns an array of AcademicRank objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AcademicRank
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
