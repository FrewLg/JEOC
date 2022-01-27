<?php

namespace App\Repository;

use App\Entity\TrainingParticipant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TrainingParticipant|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingParticipant|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingParticipant[]    findAll()
 * @method TrainingParticipant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingParticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingParticipant::class);
    }

    // /**
    //  * @return TrainingParticipant[] Returns an array of TrainingParticipant objects
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
    public function findOneBySomeField($value): ?TrainingParticipant
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
