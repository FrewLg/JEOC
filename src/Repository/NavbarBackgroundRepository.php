<?php

namespace App\Repository;

use App\Entity\NavbarBackground;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NavbarBackground|null find($id, $lockMode = null, $lockVersion = null)
 * @method NavbarBackground|null findOneBy(array $criteria, array $orderBy = null)
 * @method NavbarBackground[]    findAll()
 * @method NavbarBackground[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NavbarBackgroundRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NavbarBackground::class);
    }

    // /**
    //  * @return NavbarBackground[] Returns an array of NavbarBackground objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NavbarBackground
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
