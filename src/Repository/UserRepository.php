<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function getData($filter=[])
    {
        $qb =$this->createQueryBuilder('ui');

        if (isset($filter['name'])) {

            $qb->join("ui.userInfo","u");

            $names = explode(" ", $filter['name']);
            if (sizeof($names) == 3) {
               
                $qb->andWhere('u.first_name = :fname')
                    ->setParameter('fname', $names[0])

                    ->andWhere('u.midle_name = :mname')
                    ->setParameter('mname', $names[1])
                    ->andWhere('u.last_name = :lname')
                    ->setParameter('lname', $names[2]);
            } else if (sizeof($names) == 2) {

                $qb->andWhere('u.first_name = :fname')
                    ->setParameter('fname', $names[0])

                    ->andWhere('u.midle_name = :mname')
                    ->setParameter('mname', $names[1]);
            } else if (sizeof($names) == 1) {

            
                $qb=$qb->andWhere("u.first_name LIKE '%" . $names[0] . "%' or u.midle_name LIKE '%" . $names[0] . "%' or u.last_name LIKE '%" . $names[0] . "%'  or ui.username LIKE '%" . $names[0] . "%' ");
              
            }
        }
           
       return   $qb  ->orderBy('ui.id', 'ASC')
         
            ->getQuery()
         
        ;
    }
    


    public function getUser($filter=[]): ?User
    { 
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :username')
            ->orWhere('u.email = :username')
            ->setParameter('username', $filter['email'])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function search($key)
    { 
        return $this->createQueryBuilder('u')
        ->select("u.id,u.username as username, u.first_name as name ,u.email as email")
            ->orWhere("u.username like  '%".$key."%'")
            ->orWhere("u.email like  '%".$key."%'")
            ->getQuery()
            ->getResult()
        ;
    }


    public function getNotInUserGroup($filter=[])
    {
        $qb = $this->createQueryBuilder('u');

        if ( isset($filter['usergroup']) && sizeof($filter['usergroup'])) {

            $qb->andWhere('u.id not in ( :usergroup )')
                ->setParameter('usergroup', $filter['usergroup']);
        }
        $qb;



        return $qb->orderBy('u.id', 'ASC')
            ->getQuery()->getResult();
    }
    public function findForUserGroup($usergroup = null)
    {
        $qb = $this->createQueryBuilder('u');

        if (sizeof($usergroup)) {

            $qb->andWhere('u.id not in ( :usergroup )')
                ->setParameter('usergroup', $usergroup);
        }
        $qb;



        return $qb->orderBy('u.id', 'ASC')
            ->getQuery()->getResult();
    }
}
