<?php

namespace App\Repository;

use App\Entity\ThematicArea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ThematicArea|null find($id, $lockMode = null, $lockVersion = null)
 * @method ThematicArea|null findOneBy(array $criteria, array $orderBy = null)
 * @method ThematicArea[]    findAll()
 * @method ThematicArea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThematicAreaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThematicArea::class);
    }

    // /**
    //  * @return ThematicArea[] Returns an array of ThematicArea objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ThematicArea
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
