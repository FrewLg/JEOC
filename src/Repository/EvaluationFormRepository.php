<?php

namespace App\Repository;

use App\Entity\EvaluationForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EvaluationForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvaluationForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvaluationForm[]    findAll()
 * @method EvaluationForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvaluationFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvaluationForm::class);
    }

    // /**
    //  * @return EvaluationForm[] Returns an array of EvaluationForm objects
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
    public function findOneBySomeField($value): ?EvaluationForm
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
