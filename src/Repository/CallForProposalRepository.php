<?php

namespace App\Repository;

use App\Entity\CallForProposal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method CallForProposal|null find($id, $lockMode = null, $lockVersion = null)
 * @method CallForProposal|null findOneBy(array $criteria, array $orderBy = null)
 * @method CallForProposal[]    findAll()
 * @method CallForProposal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CallForProposalRepository extends ServiceEntityRepository
{
    private $security;
    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, CallForProposal::class);
        $this->security = $security;
    }

    // /**
    //  * @return CallForProposal[] Returns an array of CallForProposal objects
    //  */

    public function findByWorkunit($value)
    {

        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }



    public function getCalls($filter = [])
    {
        $qb = $this->createQueryBuilder('c');

        if (!in_array("ROLE_SUPER_ADMIN",$this->security->getUser()->getRoles())){
        if(isset($filter['college']))
            $qb->andWhere('c.college = :college')
                ->setParameter('college', $filter['college']);
        }
        if(isset($filter['approved'])){
            $qb->andWhere('c.approved = :approved')
                ->setParameter('approved', $filter['approved']);
        }
        return $qb
            ->orderBy("c.id", "DESC")
            ->getQuery();
    }
}
