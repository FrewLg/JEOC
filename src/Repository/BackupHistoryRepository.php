<?php

namespace App\Repository;

use App\Entity\BackupHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BackupHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BackupHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BackupHistory[]    findAll()
 * @method BackupHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BackupHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BackupHistory::class);
    }

    // /**
    //  * @return BackupHistory[] Returns an array of BackupHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BackupHistory
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
