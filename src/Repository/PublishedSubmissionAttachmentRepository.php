<?php

namespace App\Repository;

use App\Entity\PublishedSubmissionAttachment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PublishedSubmissionAttachment|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublishedSubmissionAttachment|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublishedSubmissionAttachment[]    findAll()
 * @method PublishedSubmissionAttachment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublishedSubmissionAttachmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublishedSubmissionAttachment::class);
    }

    // /**
    //  * @return PublishedSubmissionAttachment[] Returns an array of PublishedSubmissionAttachment objects
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
    public function findOneBySomeField($value): ?PublishedSubmissionAttachment
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
