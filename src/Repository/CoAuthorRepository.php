<?php

namespace App\Repository;

use App\Entity\CoAuthor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CoAuthor|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoAuthor|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoAuthor[]    findAll()
 * @method CoAuthor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoAuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoAuthor::class);
    }

    // /**
    //  * @return CoAuthor[] Returns an array of CoAuthor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CoAuthor
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
