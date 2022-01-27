<?php

namespace App\Repository;

use App\Entity\PublishedTopic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PublishedTopic|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublishedTopic|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublishedTopic[]    findAll()
 * @method PublishedTopic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublishedTopicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublishedTopic::class);
    }

    // /**
    //  * @return PublishedTopic[] Returns an array of PublishedTopic objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PublishedTopic
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
