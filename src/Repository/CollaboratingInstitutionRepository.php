<?php

namespace App\Repository;

use App\Entity\CollaboratingInstitution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CollaboratingInstitution|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollaboratingInstitution|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollaboratingInstitution[]    findAll()
 * @method CollaboratingInstitution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaboratingInstitutionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CollaboratingInstitution::class);
    }

    // /**
    //  * @return CollaboratingInstitution[] Returns an array of CollaboratingInstitution objects
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
    public function findOneBySomeField($value): ?CollaboratingInstitution
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
