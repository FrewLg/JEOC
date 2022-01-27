<?php

namespace App\Controller;

use App\Entity\WorkUnit;
use App\Form\WorkUnitType;
use App\Repository\WorkUnitRepository;
use App\Entity\ThematicArea;
use App\Form\ThematicAreaType;
use App\Repository\ThematicAreaRepository;
use App\Entity\GuidelineForReviewer;
use App\Form\GuidelineForReviewerType;
use App\Repository\GuidelineForReviewerRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Form\InstitutionalReviewersBoardType;
use App\Entity\InstitutionalReviewersBoard;
use App\Repository\InstitutionalReviewersBoardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Guidelines;
use App\Form\GuidelinesType;
use App\Repository\GuidelinesRepository;
/**
 * @Route("/colleges")
 */
class WorkUnitController extends AbstractController
{
    /**
     * @Route("/", name="work_unit_index", methods={"GET"})
     */
    public function index(WorkUnitRepository $workUnitRepository): Response
    {
        return $this->render('work_unit/index.html.twig', [
            'work_units' => $workUnitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="work_unit_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $workUnit = new WorkUnit();
        $form = $this->createForm(WorkUnitType::class, $workUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($workUnit);
            $entityManager->flush();

            return $this->redirectToRoute('work_unit_index');
        }

        return $this->render('work_unit/new.html.twig', [
            'work_unit' => $workUnit,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{prefix}/view", name="work_unit_show", methods={"GET","POST"})
     */
    public function show(Request $request, WorkUnit $workUnit, ThematicAreaRepository $thematicAreaRepository, InstitutionalReviewersBoardRepository $institutionalReviewersBoardRepository, GuidelinesRepository $guidelinesRepository): Response
    {
    
	$entityManager = $this->getDoctrine()->getManager();
	$thematicAreas = $entityManager->getRepository(ThematicArea::class)->findBy(['work_unit' => $workUnit ] );
	$guidelines = $entityManager->getRepository(Guidelines::class)->findBy(['work_unit' => $workUnit ] );
	$thematicArea = new ThematicArea();
            $thematicAreaform = $this->createForm(ThematicAreaType::class, $thematicArea);
        $thematicAreaform->handleRequest($request); 
        if ($thematicAreaform->isSubmitted() && $thematicAreaform->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
           $thematicArea->setWorkunit($workUnit);
	  # $thematicArea->setCreatedAt(new \DateTime());
            $entityManager->persist($thematicArea);
            $entityManager->flush();

            return $this->redirectToRoute('work_unit_show', array('prefix' => $workUnit->getPrefix()));
        }

	$guideline_for_reviewers = $entityManager->getRepository(GuidelineForReviewer::class)->findBy(['workunit' => $workUnit ] );
  $guidelineForReviewer = new GuidelineForReviewer();
        $formGuidelineForReviewer = $this->createForm(GuidelineForReviewerType::class, $guidelineForReviewer);
        $formGuidelineForReviewer->handleRequest($request);

        if ($formGuidelineForReviewer->isSubmitted() && $formGuidelineForReviewer->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $guidelineForReviewer->setWorkunit($workUnit);
            $guidelineForReviewer->setCreatedAt(new \DateTime());
            $entityManager->persist($guidelineForReviewer);
            $entityManager->flush();
            return $this->redirectToRoute('work_unit_show', array('prefix' => $workUnit->getPrefix()));
        }
	$guideline = new Guidelines();        
	$guidelineform = $this->createFormBuilder($guideline)  
         ->add('guideline')
 
           ->add('attachment', FileType::class, [
                'label' => 'Guideline attachment  file',
 
                'mapped' => false, 
                'required' => false,
               
            ])
                    ->getForm(); 
        $guidelineform->handleRequest($request);


        if ($guidelineform->isSubmitted() && $guidelineform->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
             $file3 = $guideline->getAttachment();               
   if ($file3){ 
   echo ' file not uploaded';
}   else{
	 $file3 = $guidelineform->get('attachment')->getData();  
          $fileName3 = md5(uniqid()).'.'.$file3->guessExtension();  
	  $file3->move($this->getParameter('review_files'), $fileName3);  
	 $guideline->setWorkunit($workUnit);
	  $guideline->setCreatedAt(new \DateTime());
           $guideline->setAttachment($fileName3); 
         }
         
        if ($guidelineform->isSubmitted() && $guidelineform->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($guideline);
            $entityManager->flush();

            return $this->redirectToRoute('work_unit_show', array('prefix' => $workUnit->getPrefix()));
        }
        }
        ///////////////institutiona review board members
	$AllIRBMembers = $entityManager->getRepository(InstitutionalReviewersBoard::class)->findBy(['workunit' => $workUnit ] );
#dd($institutionalReviewersBoard); 
$institutionalReviewersBoard= new InstitutionalReviewersBoard() ;
        #$form = $this->createForm(WorkUnitType::class, $workUnit);
	$i_r_b_form = $this->createForm(InstitutionalReviewersBoardType::class, $institutionalReviewersBoard);
        $i_r_b_form->handleRequest($request);

        if ($i_r_b_form->isSubmitted() && $i_r_b_form->isValid()) {
           # $this->getDoctrine()->getManager()->flush();
    $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($institutionalReviewersBoard);
            $entityManager->flush();

             return $this->redirectToRoute('work_unit_show', array('prefix' => $workUnit->getPrefix()));
        } 
        //to be changerd later
	        $form = $this->createForm(WorkUnitType::class, $workUnit);
	 $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

             return $this->redirectToRoute('work_unit_show', array('prefix' => $workUnit->getPrefix()));
        }            
        return $this->render('work_unit/show.html.twig', [
            'work_unit' => $workUnit,
	     'guidelines' => $guidelines,
	     'guideline_for_reviewers' => $guideline_for_reviewers,
	     'formguidelineforReviewer' => $formGuidelineForReviewer->createView(),
	     'form' => $form->createView(),
	     'institutional_reviewers_boards'=> $AllIRBMembers,
	     'guidelineform'=>$guidelineform->createView(),
	     'thematicAreaform'=> $thematicAreaform->createView(),
             'thematic_areas' => $thematicAreas,
        ]);
    }

/**
     * @Route("/{prefix}/details", name="work_unit_details", methods={"GET","POST"})
     */
    public function details(Request $request, WorkUnit $workUnit, ThematicAreaRepository $thematicAreaRepository,GuidelinesRepository $guidelinesRepository): Response
    {
    
	$entityManager = $this->getDoctrine()->getManager();
	$thematicAreas = $entityManager->getRepository(ThematicArea::class)->findBy(['work_unit' => $workUnit ] );
	$guidelines = $entityManager->getRepository(Guidelines::class)->findBy(['work_unit' => $workUnit ] );
	 
        return $this->render('work_unit/details.html.twig', [
            'work_unit' => $workUnit,
	     'guidelines' => $guidelines, 
             'thematic_areas' => $thematicAreas,
        ]);
    }


   /**
     * @Route("{id}/download", name="download", methods={"GET","POST"})
     */
	public function download(Guideline $guideline, WorkUnit $workUnit)
	{	
	            $entityManager = $this->getDoctrine()->getManager();
		$guidelines = $entityManager->getRepository(Guidelines::class)->findBy(['work_unit' => $workUnit ] );
    // send the file contents and force the browser to download it
	$theattachment=$guidelines->getAttachment();
	    return $this->file('/proposal/$theattachment');
	}
    /**
     * @Route("/{id}/edit", name="work_unit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, WorkUnit $workUnit): Response
    {
        $form = $this->createForm(WorkUnitType::class, $workUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('work_unit_index');
        }

        return $this->render('work_unit/edit.html.twig', [
            'work_unit' => $workUnit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="work_unit_delete", methods={"DELETE"})
     */
    public function delete(Request $request, WorkUnit $workUnit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workUnit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($workUnit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('work_unit_index');
    }
}
