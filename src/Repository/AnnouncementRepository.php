<?php

namespace App\Repository;

use App\Entity\Announcement;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Announcement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Announcement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Announcement[]    findAll()
 * @method Announcement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnouncementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Announcement::class);
    }

    // /**
    //  * @return Announcement[] Returns an array of Announcement objects
    //  */

    public function getData($filter = [])
    {
        $qb = $this->createQueryBuilder('a');
        if (isset($filter['sdfghj']))
            $qb->andWhere('a.exampleField = :val')
                ->setParameter('val', $filter['dfgh']);
        return $qb->orderBy('a.id', 'ASC')
            ->getQuery();
    }

    public function getPosted($limit = null)
    {
        $now = (new DateTime('now'))->format('Y-m-d H:i');
        $qb = $this->createQueryBuilder('a');
        $qb->andWhere('a.isPosted = 1')->andWhere(" :now between  a.openAt and a.closeAt")
        ->setParameter('now', $now);
        return $qb->orderBy('a.id', 'DESC')
            ->getQuery();
    }


    /*
    public function findOneBySomeField($value): ?Announcement
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
