<?php

namespace App\Repository;

use App\Entity\DirectorateOfficeUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DirectorateOfficeUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method DirectorateOfficeUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method DirectorateOfficeUser[]    findAll()
 * @method DirectorateOfficeUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DirectorateOfficeUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DirectorateOfficeUser::class);
    }

    // /**
    //  * @return DirectorateOfficeUser[] Returns an array of DirectorateOfficeUser objects
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
    public function findOneBySomeField($value): ?DirectorateOfficeUser
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
