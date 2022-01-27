<?php

namespace App\Repository;

use App\Entity\ResearchTimeTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResearchTimeTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResearchTimeTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResearchTimeTable[]    findAll()
 * @method ResearchTimeTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResearchTimeTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResearchTimeTable::class);
    }

    // /**
    //  * @return ResearchTimeTable[] Returns an array of ResearchTimeTable objects
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
    public function findOneBySomeField($value): ?ResearchTimeTable
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
