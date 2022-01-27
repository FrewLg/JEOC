<?php

namespace App\Repository;

use App\Entity\BackupSetting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BackupSetting|null find($id, $lockMode = null, $lockVersion = null)
 * @method BackupSetting|null findOneBy(array $criteria, array $orderBy = null)
 * @method BackupSetting[]    findAll()
 * @method BackupSetting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BackupSettingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BackupSetting::class);
    }

    // /**
    //  * @return BackupSetting[] Returns an array of BackupSetting objects
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
    public function findOneBySomeField($value): ?BackupSetting
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
