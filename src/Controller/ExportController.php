<?php

namespace App\Controller;
use App\Entity\CallForProposal;
use App\Entity\CoAuthor;
use App\Entity\CollaboratingInstitution;
use App\Entity\College;
use App\Entity\Submission;

use App\Entity\TrainingParticipant;
use App\Entity\ThematicArea;
use App\Filter\Type\FilterFunctions;
use App\Filter\Type\SubmissionFilterType; 
use App\Repository\SubmissionRepository;
use App\Utils\Constants;
use Composer\Console\HtmlOutputFormatter;
use Doctrine\ORM\Query\Expr;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\ResponseHeaderBag; 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Html;
 use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/export")
 */

class    ExportController   extends AbstractController {
   
    
     /**
     * @Route("/research-theams", name="exportexcel", methods={"GET","POST"})
     */
    public function theams(   )
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); 
        $em = $this->getDoctrine()->getManager();  
         $submissions = $em->getRepository(Submission::class)->findAll(); 
        $spreadsheet = new Spreadsheet(); 
        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */


        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No.');
        $sheet->setCellValue('B1', 'Title.');
        $sheet->setCellValue('C1', 'PI');
        $sheet->setCellValue('D1', 'Co-PI (s)');
        $sheet->setCellValue('E1', 'PI\'s Institute');
        $sheet->setCellValue('F1', 'Not confirmed');
        $sheet->setCellValue('G1', 'PI\'s Department');
        $sheet->setTitle("Researcher"); 
        $counter = 2;
        foreach ($submissions as $phoneNumber) {
            $sheet->setCellValue('A' . $counter, $phoneNumber->getId());
            $sheet->setCellValue('B' . $counter, $phoneNumber->getTitle());
            $counter2 = 2; 
            ########################
            $sheet->setCellValue('C' . $counter, $phoneNumber->getAuthor()->getUserInfo());
            $sheet->setCellValue('E' . $counter, $phoneNumber->getAuthor()->getUserInfo()->getCollege());
            $sheet->setCellValue('G' . $counter, $phoneNumber->getAuthor()->getUserInfo()->getDepartment());
             foreach ($phoneNumber->getCoAuthors() as $CoAuthors) {
             $sheet->setCellValue('D' . $counter, $CoAuthors->getResearcher()->getUserInfo());

             if ( $CoAuthors->getConfirmed() == NULL ){
              $sheet->setCellValue('F' . $counter, $CoAuthors->getResearcher()->getUserInfo());
               
               } 
             $counter++;
            $counter2++;  
     } 
                   
############################
          $counter++;
        }
         $writer = new Xlsx($spreadsheet);
         $fileName = 'Researchers.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
         $writer->save($temp_file);
         return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
         
    } 
 

  
 
     /**
     * @Route("/participant", name="exportexcelparticipant", methods={"GET","POST"})
     */
    public function trainingparticipant(  )
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();
 
          $submissions = $em->getRepository(TrainingParticipant::class)->findAll();
         $spreadsheet = new Spreadsheet();
         /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No.');
        $sheet->setCellValue('B1', 'Full name');
         $sheet->setCellValue('C1', 'Participant\'s Institute');
        $sheet->setCellValue('D1', 'Participant\'s College');
        $sheet->setTitle("Participants");
 
        $counter = 2;
        foreach ($submissions as $phoneNumber) {
            $sheet->setCellValue('A' . $counter, $phoneNumber->getId()); 
            $sheet->setCellValue('B' . $counter, $phoneNumber->getParticipant()->getUserInfo());
            $sheet->setCellValue('C' . $counter, $phoneNumber->getParticipant()->getUserInfo()->getCollege());
            $sheet->setCellValue('D' . $counter, $phoneNumber->getParticipant()->getUserInfo()->getDepartment()); 
          $counter++;
        }
         $writer = new Xlsx($spreadsheet);
         $fileName = 'Traninig participant.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        
         $writer->save($temp_file);
        
         return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
         
    } 

    /**
     * @Route("/external-rev", name="alexternal_rev", methods={"GET","POST"})
     */
    public function externalreviewers(  ): Response
    {
        $this->denyAccessUnlessGranted('assn_clg_cntr');

        $entityManager = $this->getDoctrine()->getManager(); 
        #######################
        $query2 = $entityManager->createQuery(
            'SELECT  u.email , u.id, pi.last_name , pi.first_name, pi.midle_name,  pi.image, u.is_reviewer,   count(b.id) as subs,  count(u.id) as review_assignment
            FROM App:ReviewAssignment s 
            JOIN s.reviewer u 
            JOIN u.userInfo pi 
            JOIN s.submission b 
            where  u.is_reviewer =:external    GROUP BY u.id ORDER BY  pi.first_name
        ')
        ->setParameter('external', 1  ); 
        $recepientextrnal = $query2->getResult();
        $spreadsheet = new Spreadsheet();
           /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'No.');
          $sheet->setCellValue('B1', 'Full name');
          $sheet->setCellValue('C1', 'Email');
          $sheet->setCellValue('D1', 'Number of assignments');
          $sheet->setCellValue('E1', 'Staff Membership');
          $sheet->setTitle("External reviewers");
          $idcounter = 1;
   
          $counter = 2;
          foreach ($recepientextrnal as $phoneNumber) {
              $sheet->setCellValue('A' . $counter, $idcounter); 
              $sheet->setCellValue('B' . $counter, $phoneNumber['first_name'].$phoneNumber['midle_name'].$phoneNumber['last_name']); 
              $sheet->setCellValue('C' . $counter, $phoneNumber['email']);
              $sheet->setCellValue('D' . $counter, $phoneNumber['review_assignment']);
           if($phoneNumber['is_reviewer']==1){ 
                $sheet->setCellValue('E' . $counter, "External reviewer");

              }
              
            $idcounter++;
            $counter++;
          }
           $writer = new Xlsx($spreadsheet);
           $fileName = 'External reviewers.xlsx';
          $temp_file = tempnam(sys_get_temp_dir(), $fileName);
          
           $writer->save($temp_file);
          
           return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);

    } 


     /**
     * @Route("/allaccepted", name="allaccepted", methods={"GET","POST"})
     */
    public function allaccepted(  Request $request,   PaginatorInterface $paginator )
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); 
        $entityManager = $this->getDoctrine()->getManager();
        $filterform=$this->createFormBuilder()->add("status",ChoiceType::class,[
          "multiple"=>true,
          "required"=>true,
          "expanded"=>true, 
          "choices"=>[
            "Accepted"=>Constants::SUBMISSION_STATUS_ACCEPTED,
            "Accepted with minor revision"=>Constants::SUBMISSION_STATUS_ACCEPTED_WITH_MINOR_REVISION,
            "Accepted with major revision"=>Constants::SUBMISSION_STATUS_ACCEPTED_WITH_MAJOR_REVISION,
            "Decline"=>Constants::SUBMISSION_STATUS_DECLINED,
          ]
          ])->getForm();
          $status=$request->query->get("status");
       
          $filterform->handleRequest($request);
          if($filterform->isSubmitted() && $filterform->isValid()){
            
            $submissions=$this->getDoctrine()->getRepository(Submission::class)->getSubmissions(["status"=>$filterform->getData()['status']]);
            if ($request->query->get("export")){
              $spreadsheet = new Spreadsheet();
              /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
             $sheet = $spreadsheet->getActiveSheet();
             $sheet->setCellValue('A1', 'No.');
             $sheet->setCellValue('B1', 'Title');
              $sheet->setCellValue('C1', 'Decision '); 
             $sheet->setTitle("Editorial decisions");
      
             $idcounter = 1;
             $counter = 2;
             foreach ($submissions as $phoneNumber) {
                 $sheet->setCellValue('A' . $counter, $idcounter); 
                 $sheet->setCellValue('B' . $counter, $phoneNumber['title']); 
                 $sheet->setCellValue('C' . $counter, $phoneNumber['remark']);
                 
               $counter++;
               $idcounter++;
             }
              $writer = new Xlsx($spreadsheet);
              $fileName = 'Editorial decisions.xlsx';
             $temp_file = tempnam(sys_get_temp_dir(), $fileName);
             
              $writer->save($temp_file);
             
              return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
   
            }
        } else{
            $submissions=$this->getDoctrine()->getRepository(Submission::class)->getSubmissions();

          } 
       
          
                 $Allsubmissions = $paginator->paginate(
                  // Doctrine Query, not results
                  $submissions,
                  // Define the page parameter
                  $request->query->getInt('page', 1),
                  // Items per page
                  25,array('wrap-queries'=>true)
              );
              $info='All Accepted';
         ################################
         return $this->render('dashboard/submissions.html.twig', [
           'submissions' => $Allsubmissions,
          'info' => $info,
          'filterform'=>$filterform->createView(),
      ]);
         
    }

 /**
     * @Route("/theme", name="allbythemeex", methods={"GET","POST"})
     */
    public function allbythemeex(   )
    {
      $this->denyAccessUnlessGranted('ROLE_ADMIN'); 
      $em = $this->getDoctrine()->getManager();  
       $submissions = $em->getRepository(ThematicArea::class)->findAll(); 
      #######################################
      $entityManager = $this->getDoctrine()->getManager(); 

      $query2 = $entityManager->createQuery(
        'SELECT  t.name as ThematicArea, pi.last_name as piLastName, pi.first_name as piFirstName, pi.midle_name as PIMiddleName, 
         s.title as title
        FROM App:CoAuthor c 
        JOIN c.submission s 
        JOIN s.thematic_area t 
        JOIN s.author u 
        JOIN u.userInfo pi   
        GROUP BY  s.title  ORDER BY  t.id
    ');
    // ->setParameter('external', 1  ); 
    $recepientextrnal = $query2->getResult();
 
// foreach ($submissions as $ds){
//   $ds ->getThematicArea()->getName() ;
//    dd($ds);
// }



       ####################################
      $spreadsheet = new Spreadsheet(); 
      /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */


      $sheet = $spreadsheet->getActiveSheet();
      $sheet->setCellValue('A1', 'No.');
      $sheet->setCellValue('B1', 'Thematic area.');
      $sheet->setCellValue('C1', 'Title');
      $sheet->setCellValue('D1', 'PI');
      $sheet->setCellValue('E1', 'PI\'s Institute');  
       $sheet->setTitle("Researchs by Thematic areas "); 
      $counter = 2;
      foreach ($submissions as $phoneNumber) {
          $sheet->setCellValue('A' . $counter, $counter);
          $sheet->setCellValue('B' . $counter, $phoneNumber->getName());
          $counter2 = 2; 
          ########################
          // $sheet->setCellValue('C' . $counter, $phoneNumber->getAuthor()->getUserInfo());
          
          foreach ($phoneNumber->getSubmissions() as $CoAuthors) {
            $sheet->setCellValue('C' . $counter, $CoAuthors->getTitle());
            $sheet->setCellValue('D' . $counter, $CoAuthors->getAuthor()->getUserInfo());  
            $sheet->setCellValue('E' . $counter, $CoAuthors->getAuthor()->getUserInfo()->getCollege());
          //  $counter++; 
          $counter2++;  
          

        $counter++;
        $counter2++;  
           } 
                 
############################
        $counter++;
      }
       $writer = new Xlsx($spreadsheet);
       $fileName = 'Researchers.xlsx';
      $temp_file = tempnam(sys_get_temp_dir(), $fileName);
       $writer->save($temp_file);
       return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
       
         
    }


 /**
     * @Route("/rev-result", name="review_result", methods={"GET","POST"})
     */
  
    
    public function results(   )
    {
      $this->denyAccessUnlessGranted('ROLE_ADMIN'); 
      $em = $this->getDoctrine()->getManager();  
       $submissions = $em->getRepository(Submission::class)->findAll(); 
      
      $spreadsheet = new Spreadsheet(); 
      /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */


      $sheet = $spreadsheet->getActiveSheet();
      $sheet->setCellValue('A1', 'No.');
      $sheet->setCellValue('B1', 'Title');
      $sheet->setCellValue('C1', 'Review decision');
      $sheet->setCellValue('D1', 'Reviewer');
        $sheet->setTitle("Research review result ");  
       
        $counter = 2;
        foreach ($submissions as $phoneNumber) {
            $sheet->setCellValue('A' . $counter, $phoneNumber->getId());
            $sheet->setCellValue('B' . $counter, $phoneNumber->getTitle());
            $counter2 = 2; 
            ########################
            // $sheet->setCellValue('C' . $counter, $phoneNumber->getAuthor()->getUserInfo()); 
             foreach ($phoneNumber->getReviews() as $CoAuthors) {

            //  $sheet->setCellValue('C' . $counter, $CoAuthors->getReviewedBy()->getIsReviewer());

             if($CoAuthors->getRemark()==1){
                             
            $sheet->setCellValue('C' . $counter, "Declined");
  
            }
            elseif($CoAuthors->getRemark()==2){
              $sheet->setCellValue('C' . $counter, "Accepted with major revision");
  
            }
  
            elseif($CoAuthors->getRemark()==3){
              $sheet->setCellValue('C' . $counter, "Accepted with minor revision");
  
            }
            elseif($CoAuthors->getRemark()==4){
              $sheet->setCellValue('C' . $counter, "Accepted");
  
            }


             if ( $CoAuthors->getReviewedBy()->getIsReviewer()== NULL ){
              $sheet->setCellValue('D' . $counter, "Internal");
               
               } 
               elseif($CoAuthors->getReviewedBy()->getIsReviewer()== 1){
                $sheet->setCellValue('D' . $counter, "External");

               }
             $counter++;
            $counter2++;  
     } 
                   
############################
          $counter++;
        }
    $counter = 2;
      $writer = new Xlsx($spreadsheet);
         $fileName = 'Review result.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
         $writer->save($temp_file);
         return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
        
         
    }


    public function exportall($query){
      
      $spreadsheet = new Spreadsheet();
     /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'No.');
    $sheet->setCellValue('B1', 'Full name');
     $sheet->setCellValue('C1', 'Email ');
    $sheet->setCellValue('D1', 'Number of assignments');
    $sheet->setCellValue('E1', 'Staff Membership');
    $sheet->setTitle("Internal reviewers");

    $idcounter = 1;
    $counter = 2;
    foreach ($$query as $phoneNumber) {
        $sheet->setCellValue('A' . $counter, $idcounter); 
        $sheet->setCellValue('B' . $counter, $phoneNumber['first_name'].$phoneNumber['midle_name'].$phoneNumber['last_name']); 
        $sheet->setCellValue('C' . $counter, $phoneNumber['email']);
        $sheet->setCellValue('D' . $counter, $phoneNumber['review_assignment']);
         if($phoneNumber['is_reviewer']==NULL){

          $sheet->setCellValue('E' . $counter, "Internal reviewer");

        }
      $counter++;
      $idcounter++;
    }
     $writer = new Xlsx($spreadsheet);
     $fileName = 'Internal reviewers.xlsx';
    $temp_file = tempnam(sys_get_temp_dir(), $fileName);
    
     $writer->save($temp_file);
    
     return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);

} 


    

    /**
     * @Route("/internal-rev", name="internal_rev", methods={"GET","POST"})
     */
    public function internalreviewers( ): Response
    {
        $this->denyAccessUnlessGranted('assn_clg_cntr');

        $entityManager = $this->getDoctrine()->getManager(); 
        #######################
        $query2 = $entityManager->createQuery(
            'SELECT  u.email , u.id, pi.last_name , pi.first_name, pi.midle_name,  pi.image, u.is_reviewer,   count(b.id) as subs,  count(u.id) as review_assignment
            FROM App:ReviewAssignment s 
            JOIN s.reviewer u 
            JOIN u.userInfo pi 
            JOIN s.submission b 
            where  u.is_reviewer is NULL    GROUP BY u.id ORDER BY  pi.first_name
        ');
        // ->setParameter('external', 1  ); 
        $recepientextrnal = $query2->getResult();
      ######################## 

       //   dd($recepientextrnal);
            $spreadsheet = new Spreadsheet();
           /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
          $sheet = $spreadsheet->getActiveSheet();
          $sheet->setCellValue('A1', 'No.');
          $sheet->setCellValue('B1', 'Full name');
           $sheet->setCellValue('C1', 'Email ');
          $sheet->setCellValue('D1', 'Number of assignments');
          $sheet->setCellValue('E1', 'Staff Membership');
          $sheet->setTitle("Internal reviewers");
   
          $idcounter = 1;
          $counter = 2;
          foreach ($recepientextrnal as $phoneNumber) {
              $sheet->setCellValue('A' . $counter, $idcounter); 
              $sheet->setCellValue('B' . $counter, $phoneNumber['first_name'].$phoneNumber['midle_name'].$phoneNumber['last_name']); 
              $sheet->setCellValue('C' . $counter, $phoneNumber['email']);
              $sheet->setCellValue('D' . $counter, $phoneNumber['review_assignment']);
               if($phoneNumber['is_reviewer']==NULL){

                $sheet->setCellValue('E' . $counter, "Internal reviewer");

              }
            $counter++;
            $idcounter++;
          }
           $writer = new Xlsx($spreadsheet);
           $fileName = 'Internal reviewers.xlsx';
          $temp_file = tempnam(sys_get_temp_dir(), $fileName);
          
           $writer->save($temp_file);
          
           return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);

    } 

}
