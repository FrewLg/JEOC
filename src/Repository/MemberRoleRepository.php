<?php

namespace App\Repository;

use App\Entity\MemberRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MemberRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberRole[]    findAll()
 * @method MemberRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemberRole::class);
    }

    // /**
    //  * @return MemberRole[] Returns an array of MemberRole objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MemberRole
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
