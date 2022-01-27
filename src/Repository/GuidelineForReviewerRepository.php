<?php

namespace App\Repository;

use App\Entity\GuidelineForReviewer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GuidelineForReviewer|null find($id, $lockMode = null, $lockVersion = null)
 * @method GuidelineForReviewer|null findOneBy(array $criteria, array $orderBy = null)
 * @method GuidelineForReviewer[]    findAll()
 * @method GuidelineForReviewer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GuidelineForReviewerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GuidelineForReviewer::class);
    }

    // /**
    //  * @return GuidelineForReviewer[] Returns an array of GuidelineForReviewer objects
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
    public function findOneBySomeField($value): ?GuidelineForReviewer
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
