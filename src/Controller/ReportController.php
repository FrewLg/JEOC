<?php

namespace App\Controller;

use App\Entity\Submission;
use App\Form\SubmissionType;
use App\Entity\CallForProposal; 
use App\Repository\CallForProposalRepository;
use App\Repository\GuidelinesRepository;
use App\Repository\SubmissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;  
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Entity\Review;
use Symfony\Component\Form\Extension\Core\Type\DateType; 
use App\Entity\CollaboratingInstitution;
use App\Form\CollaboratingInstitutionType;
use App\Repository\CollaboratingInstitutionRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\WorkUnit;
use App\Repository\WorkUnitRepository;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use phpDocumentor\Reflection\DocBlock\Serializer;
use App\Form\ReviewType;
use App\Entity\Expense;
use App\Repository\ExpenseRepository;
use App\Entity\CoAuthor;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use App\Repository\InstitutionalReviewersBoardRepository;
use App\Entity\InstitutionalReviewersBoard;
use Lexik\Bundle\FormFilterBundle\Filter\Condition\ConditionBuilderInterface; 
use App\Form\CoAuthorType;
use App\Repository\CoAuthorRepository;
use App\Entity\ThematicArea;
use App\Form\ThematicAreaType;
use App\Repository\ThematicAreaRepository;
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Repository\ReviewRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType; 
use App\Entity\ReviewAssignment;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Form\ReviewAssignmentType;
use App\Repository\ReviewAssignmentRepository;
use App\Filter\Type\FilterFunctions; 
use App\Filter\Type\SubmissionFilterType;
use Doctrine\DBAL\Abstraction\Result;

/**
 * @Route("/report")
 */
class ReportController extends AbstractController
{
    /**
     * @Route("/irb", name="irb_report", methods={"GET"})
     */ 
    public function irbreport(InstitutionalReviewersBoardRepository $institutionalReviewersBoardRepository): Response
    {
         	  
$em = $this->getDoctrine()->getManager();
	$qb = $em->createQueryBuilder();
	$result = $qb
 	->select( 'COUNT(e.reviewer) as IRB_Members , e.affiliation as affiliation ' )
	->from( 'App\Entity\InstitutionalReviewersBoard', 'e' )
	->andWhere(  'e.workunit = :college' ) 
	->setParameter( 'college', 1 )
	->groupBy('e.affiliation')
	->getQuery()->getResult();
	; 
 
	foreach($result as $k =>$a){
    $array[$k] = json_decode(json_encode($a));
    
}
 
	$pieChart = new PieChart(); 
	$pieChart->getData()->setArrayToDataTable(array($result)); 
     # [['Année', 'Recette pétrolière'],   
#		['Mega',     39],
#		['Technology',     22],
 #	        ['Community ',      72],
  #    ]
    #        )); 
    $pieChart->getOptions()->setTitle('Publicsations');
    $pieChart->getOptions()->setHeight(400);
    $pieChart->getOptions()->setWidth(600);
    $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
    $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
    $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
    $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
    $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);	
        return $this->render('report/irb.html.twig', [
            'institutional_reviewers_boards' => $result,
            'piechart' => $pieChart,
        ]);
    } 
  
   /**
     * @Route("/publications", name="publications_report", methods={"GET"})
     */ 
    public function publications(SubmissionRepository $submissionRepository): Response
    {
   	  
     
$em = $this->getDoctrine()->getManager();
	$qb = $em->createQueryBuilder();
	$result = $qb
 	->select('COUNT(e.id) as Proposals , e.submission_type as Subbmission_type' )
	->from('App\Entity\Submission', 'e')
	->andWhere('e.complete = :status') 
	->setParameter( 'status', 0)  
	->groupBy('e.submission_type')
	->getQuery()->getResult();
	; 
   
   $totalArticles = $submissionRepository->createQueryBuilder('a')
 
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();
            
    $toJSON = json_encode($result);
    $pieChart = new PieChart();
    $pieChart->getData()->setArrayToDataTable(array($result)); 
//    $pieChart->getData()->setArrayToDataTable(
    #);
  //  [['Publications', 'Count'],
//[$result[0], $result['Subbmission_type']],

  //]
      
  //);
    $pieChart->getOptions()->setTitle('Publications');
    $pieChart->getOptions()->setHeight(400);
    $pieChart->getOptions()->setWidth(600);
    $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
    $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
    $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
    $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
    $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
   

        return $this->render('report/publications_report.html.twig', [
            'institutional_reviewers_boards' => $result,
            'piechart' => $pieChart,
            'total'=>$totalArticles,
        ]);
    } 
    
}
