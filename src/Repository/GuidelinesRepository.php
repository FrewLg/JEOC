<?php

namespace App\Repository;

use App\Entity\Guidelines;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Guidelines|null find($id, $lockMode = null, $lockVersion = null)
 * @method Guidelines|null findOneBy(array $criteria, array $orderBy = null)
 * @method Guidelines[]    findAll()
 * @method Guidelines[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GuidelinesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Guidelines::class);
    }

    // /**
    //  * @return Guidelines[] Returns an array of Guidelines objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Guidelines
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
