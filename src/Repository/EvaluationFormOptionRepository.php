<?php

namespace App\Repository;

use App\Entity\EvaluationFormOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EvaluationFormOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvaluationFormOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvaluationFormOption[]    findAll()
 * @method EvaluationFormOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvaluationFormOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvaluationFormOption::class);
    }

    // /**
    //  * @return EvaluationFormOption[] Returns an array of EvaluationFormOption objects
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
    public function findOneBySomeField($value): ?EvaluationFormOption
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
