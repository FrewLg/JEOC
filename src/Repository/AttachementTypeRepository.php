<?php

namespace App\Repository;

use App\Entity\AttachementType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AttachementType|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttachementType|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttachementType[]    findAll()
 * @method AttachementType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttachementTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttachementType::class);
    }

    // /**
    //  * @return AttachementType[] Returns an array of AttachementType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AttachementType
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
