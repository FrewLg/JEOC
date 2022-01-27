<?php

namespace App\Repository;

use App\Entity\PublishedResearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PublishedResearch|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublishedResearch|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublishedResearch[]    findAll()
 * @method PublishedResearch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublishedResearchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublishedResearch::class);
    }

    // /**
    //  * @return PublishedResearch[] Returns an array of PublishedResearch objects
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
    public function findOneBySomeField($value): ?PublishedResearch
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
