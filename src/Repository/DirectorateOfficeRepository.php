<?php

namespace App\Repository;

use App\Entity\DirectorateOffice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DirectorateOffice|null find($id, $lockMode = null, $lockVersion = null)
 * @method DirectorateOffice|null findOneBy(array $criteria, array $orderBy = null)
 * @method DirectorateOffice[]    findAll()
 * @method DirectorateOffice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DirectorateOfficeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DirectorateOffice::class);
    }

    // /**
    //  * @return DirectorateOffice[] Returns an array of DirectorateOffice objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DirectorateOffice
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
