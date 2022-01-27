<?php

namespace App\Repository;

use App\Entity\Suffixe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Suffixe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Suffixe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Suffixe[]    findAll()
 * @method Suffixe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuffixeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Suffixe::class);
    }

    // /**
    //  * @return Suffixe[] Returns an array of Suffixe objects
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
    public function findOneBySomeField($value): ?Suffixe
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
