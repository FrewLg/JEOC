<?php

namespace App\Controller;
use App\Entity\InstitutionalReviewersBoard;
use App\Form\InstitutionalReviewersBoardType;
use App\Repository\InstitutionalReviewersBoardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use  CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
/**
 * @Route("/institutional/reviewers/board")
 */
class InstitutionalReviewersBoardController extends AbstractController
{
    /**
     * @Route("/", name="institutional_reviewers_board_index", methods={"GET"})
     */
    public function index(InstitutionalReviewersBoardRepository $institutionalReviewersBoardRepository): Response
    {
    	 
    	$em = $this->getDoctrine()->getManager();
	$qb = $em->createQueryBuilder();
	$qb = $qb
	->select( 'SUM(e.reviewer) as totalRequested, SUM(e.affiliation) as Totalapproved' )
	->from( 'App\Entity\InstitutionalReviewersBoard', 'e' )
	->where( $qb->expr()->andX(
	$qb->expr()->eq( 'e.specialization', ':status' ), 
	) )
	->setParameter( 'status', 1 )
	->getQuery()
	; 
	$Overall_budger_request = $qb->getResult();  
	$em = $this->getDoctrine()->getManager();
	$qb = $em->createQueryBuilder();
	$result = $qb
 	->select( 'COUNT(e.reviewer) as IRB_Members , e.affiliation as affiliation ' )
	->from( 'App\Entity\InstitutionalReviewersBoard', 'e' )
	->andWhere(  'e.workunit = :status' ) 
	->setParameter( 'status', 1 )
	->groupBy('e.affiliation')
	->getQuery()->getResult();
	;  
	#dd($result); 
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
    
	
        return $this->render('institutional_reviewers_board/index.html.twig', [
        
            'institutional_reviewers_boards' => $result,
        ]);
    }

    /**
     * @Route("/new", name="institutional_reviewers_board_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $institutionalReviewersBoard = new InstitutionalReviewersBoard();
        $form = $this->createForm(InstitutionalReviewersBoardType::class, $institutionalReviewersBoard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($institutionalReviewersBoard);
            $entityManager->flush();

            return $this->redirectToRoute('institutional_reviewers_board_index');
        }

        return $this->render('institutional_reviewers_board/new.html.twig', [
            'institutional_reviewers_board' => $institutionalReviewersBoard,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="institutional_reviewers_board_show", methods={"GET"})
     */
    public function show(InstitutionalReviewersBoard $institutionalReviewersBoard): Response
    {
        return $this->render('institutional_reviewers_board/show.html.twig', [
            'institutional_reviewers_board' => $institutionalReviewersBoard,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="institutional_reviewers_board_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, InstitutionalReviewersBoard $institutionalReviewersBoard): Response
    {
        $form = $this->createForm(InstitutionalReviewersBoardType::class, $institutionalReviewersBoard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('institutional_reviewers_board_index');
        }

        return $this->render('institutional_reviewers_board/edit.html.twig', [
            'institutional_reviewers_board' => $institutionalReviewersBoard,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="institutional_reviewers_board_delete", methods={"DELETE"})
     */
    public function delete(Request $request, InstitutionalReviewersBoard $institutionalReviewersBoard): Response
    {
        if ($this->isCsrfTokenValid('delete'.$institutionalReviewersBoard->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($institutionalReviewersBoard);
            $entityManager->flush();
        }

        return $this->redirectToRoute('institutional_reviewers_board_index');
    }
}
