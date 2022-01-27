<?php

namespace App\Repository;

use App\Entity\CallForProposal;
use App\Entity\Submission;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Submission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Submission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Submission[]    findAll()
 * @method Submission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubmissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Submission::class);
    }

    // /**
    //  * @return Submission[] Returns an array of Submission objects
    //  */

    public function getCount($filter = [])
    {
        $qb = $this->createQueryBuilder('s')->select("count(s.id)");
        if (isset($filter["submisstion_type"]) && sizeof($filter["submisstion_type"]) > 0)
            $qb->andWhere('s.submission_type in (:submission_type)')
                ->setParameter('submission_type', $filter["submisstion_type"]);
        if (isset($filter["author"]))
            $qb->andWhere('s.author = :author')
                ->setParameter('author', $filter["author"]);

        return  $qb->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getSingleScalarResult();
    }


    // public function getSubmissions($status=null)
    // {
    //     $qb= $this->createQueryBuilder('s');
    //     if(isset($status)){

    //         $qb->leftJoin("App:Review","r","with","s.id=r.submission");
    //         $qb->andWhere("r.remark= :remark")
    //         ->setParameter("remark",$status);

    //     }
    //     $qb->groupBy("s.id")->andHaving("count(s)>1"); 
    //       return  $qb->orderBy('s.id', 'ASC')
    //         ->getQuery();

    //     ;
    // }
    // sET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY','')); 
    // select submission_id from review where remark in ('Accepted','Declined') group by submission_id having count(remark) >1; 

    public function getSubmissions($filter = [])
    {
        $qb = $this->createQueryBuilder('s');
        if (isset($filter['status']) and sizeof($filter['status']) > 0) {
            $qb->leftJoin("App:Review", "r", "with", "s.id=r.submission");


            $qb->andWhere("r.remark in  (:remark)")
                ->setParameter("remark", $filter['status']);
            if (isset($filter['status']) and sizeof($filter['status']) == 1) {


                $qb->groupBy("s.id")
                    ->andHaving("count(r.remark)>1");
            } else
                $qb->groupBy("s.id")->andHaving("count(distinct(r.remark))>1");
        }
        if (isset($filter['author']) and sizeof($filter['author']) > 0) {


            $qb->andWhere("s.author in  (:author)")
                ->setParameter("author", $filter['author']);
        }
        if (isset($filter['coAuthor']) and sizeof($filter['coAuthor']) > 0) {


            $qb
            
            ->join("s.coAuthors","c","With","c.submission=s.id")
            ->join("c.researcher","uu","With","c.researcher=uu.id")
            ->andWhere("uu in  (:coAuthor)")
                ->setParameter("coAuthor", $filter['coAuthor']);
        }
        if (isset($filter['thematic_area']) and sizeof($filter['thematic_area']) > 0) {


            $qb->andWhere("s.thematic_area in  (:thematic_area)")
                ->setParameter("thematic_area", $filter['thematic_area']);
        }
        if (isset($filter['submission_type'])) {

            $qb->andWhere("s.submission_type =  :submission_type")
                ->setParameter("submission_type", $filter['submission_type']);
        }
        if (isset($filter['complete'])) {
            $qb->andWhere("s.complete =  :complete")
                ->setParameter("complete", $filter['complete']);
        }
        if (isset($filter['published'])) {
            $qb->andWhere("s.published =  :published")
                ->setParameter("published", $filter['published']);
        }
        if (isset($filter['callForProposal'])) {
            $qb->andWhere("s.callForProposal =  :callForProposal")
                ->setParameter("callForProposal", $filter['callForProposal']);
        }
        if (isset($filter['sentAt'])  && $filter['sentAt']) {
            $date = explode(" - ", $filter['sentAt']);

            // dd($date);
            $qb->andWhere("s.sent_at <= '" . (new \DateTime($date[1]))->format('Y-m-d H:i:s') . "'");
            $qb->andWhere("s.sent_at >= '" . (new \DateTime($date[0]))->format('Y-m-d H:i:s') . "'");
        }
        if (isset($filter['project_start_at'])  && $filter['project_start_at']) {
            $date = explode(" - ", $filter['project_start_at']);

            // dd($date);
            $qb->andWhere("s.project_start_at <= '" . (new \DateTime($date[1]))->format('Y-m-d H:i:s') . "'");
            $qb->andWhere("s.project_start_at >= '" . (new \DateTime($date[0]))->format('Y-m-d H:i:s') . "'");
        }
        if (isset($filter['project_end_at'])  && $filter['project_end_at']) {
            $date = explode(" - ", $filter['project_end_at']);

            // dd($date);
            $qb->andWhere("s.project_end_at <= '" . (new \DateTime($date[1]))->format('Y-m-d H:i:s') . "'");
            $qb->andWhere("s.project_end_at >= '" . (new \DateTime($date[0]))->format('Y-m-d H:i:s') . "'");
        }
        if (isset($filter['abstract'])  && $filter['abstract']) {
            $qb->andWhere("s.abstract LIKE  '%" . $filter['abstract'] . "%'");
        }
        if (isset($filter['title']) && $filter['title']) {
            $qb->andWhere("s.title LIKE  '%" . $filter['title'] . "%'");
        }
        if (isset($filter['keywords']) && $filter['keywords']) {
            $qb->andWhere("s.keywords LIKE  '%" . $filter['keywords'] . "%'");
        }
        if (isset($filter['reference']) && $filter['reference']) {
            $qb->andWhere("s.reference LIKE  '%" . $filter['reference'] . "%'");
        }
        if (isset($filter['methodology']) && $filter['methodology']) {
            $qb->andWhere("s.methodology LIKE  '%" . $filter['methodology'] . "%'");
        }
        if (isset($filter['GeneralObjective']) && $filter['GeneralObjective']) {
            $qb->andWhere("s.GeneralObjective LIKE  '%" . $filter['GeneralObjective'] . "%'");
        }
        if (isset($filter['funding_organization']) && $filter['funding_organization']) {
            $qb->andWhere("s.funding_organization LIKE  '%" . $filter['funding_organization'] . "%'");
        }

        //    dd($qb->orderBy('s.id', 'ASC')->getQuery()->getSQL());
        return  $qb->orderBy('s.id', 'ASC')
            ->getQuery();
    }







    public function getOneofItIsAccepted($status = null)
    {
        $qb = $this->createQueryBuilder('s');
        if (isset($status)) {

            $qb->leftJoin("App:Review", "r", "with", "s.id=r.submission");
            $qb->andWhere("r.remark >3");
        }
        $qb->groupBy("s.id")->andHaving("count(s)>=1");

        // dd($qb->orderBy('s.id', 'ASC')->getQuery()->getSQL());
        return  $qb->orderBy('s.id', 'ASC')
            ->getQuery();;
    }
    public function filterApproved(CallForProposal $callForProposal)
    {
        $qb = $this->createQueryBuilder('s');

        $qb->andWhere("s.callForProposal = :callForProposal")->setParameter('callForProposal', $callForProposal);

        $qb->leftJoin("App:Review", "r", "with", "s.id=r.submission");
        $qb->andWhere("r.remark = 4")
            ->andWhere("r.from_director = 1");



        // dd($qb->orderBy('s.id', 'ASC')->getQuery()->getSQL());
        return  $qb->orderBy('s.id', 'ASC')
            ->getQuery()->getResult();
    }


    // public function findBySubmissionByUser($value): ?Submission
    // {
    //     $qb= $this->createQueryBuilder('s');
    //     // ->select("count(s.id)");
    //     $userpublication = $qb
    //     ->select('COUNT(e.id) as Proposals , e.submission_type as Subbmission_type')
    //     ->from('App\Entity\Submission', 'e')
    //     ->andWhere('e.author = :publisher')
    //     ->setParameter('publisher', $value)
    //     ->groupBy('e.submission_type')
    //     ->getQuery()->getResult();

    //     return   $userpublication 
    //     ;
    // }  
    #################
    // public function findBySubmissionByDepartment($value): ?Submission
    // {
    //    return $this->createQueryBuilder('a')
    //             ->innerJoin('a.department', 'd')
    //             ->innerJoin('d.college', 'c') 
    //             ->andWhere('c.id = :e') 
    //             ->setParameter('e', $value)
    //             ->orderBy('a.id', 'ASC') 
    //             ->getQuery()
    //             ->getResult()
    //         ;
    //     }

    // public function findBySStatus(): ?Submission
    //     {
    //     $em = $this->getDoctrine()->getManager();
    //     $query = $em->createQuery(
    //         'SELECT u.email , p.id,    u.username,  p.complete, p.title  , ui.first_name
    // FROM App:CoAuthor s
    // JOIN s.researcher u
    // JOIN u.userInfo ui
    // JOIN s.submission p
    // WHERE  
    // p.complete is NULL');
    //         // ->setParameter('submission', $submission) 
    //         // ->setParameter('cstatus', 'completed' );
    //     $recepients = $query->getResult();

    //         return   $recepients 
    //         ;
    //     }   
}
