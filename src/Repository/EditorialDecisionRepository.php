<?php

namespace App\Repository;

use App\Entity\EditorialDecision;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EditorialDecision|null find($id, $lockMode = null, $lockVersion = null)
 * @method EditorialDecision|null findOneBy(array $criteria, array $orderBy = null)
 * @method EditorialDecision[]    findAll()
 * @method EditorialDecision[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EditorialDecisionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EditorialDecision::class);
    }

    // /**
    //  * @return EditorialDecision[] Returns an array of EditorialDecision objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EditorialDecision
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
