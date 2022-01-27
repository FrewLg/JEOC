<?php

namespace App\Controller;

use App\Entity\College;
use App\Form\CollegeType;
use App\Repository\CollegeRepository; 

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\Constants;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

#[Route('/college')]
class CollegeController extends AbstractController
{
    #[Route('/', name: 'college_index', methods: ['GET'])]
    public function index(CollegeRepository $collegeRepository): Response
    {
        return $this->render('college/index.html.twig', [
            'colleges' => $collegeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'college_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $college = new College();
        $form = $this->createForm(CollegeType::class, $college);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($college);
            $entityManager->flush();

            return $this->redirectToRoute('college_index');
        }

        return $this->render('college/new.html.twig', [
            'college' => $college,
            'form' => $form->createView(),
        ]);
    }


        /**
     * @Route("/details", name="college_details", methods={"GET","POST"})
     */

    public function showdetail( Request $request  ): Response
    {

    $this->denyAccessUnlessGranted('assn_clg_cntr');

    $college=$this->getUser()->getUserInfo()->getCollege();

    $entityManager = $this->getDoctrine()->getManager();
    $thematicAreas = $entityManager->getRepository(ThematicArea::class)->findBy(['college' => $college ] );
    $guidelines = $entityManager->getRepository(Guidelines::class)->findBy(['college' => $college ] );
    $thematicArea = new ThematicArea();
            $thematicAreaform = $this->createForm(ThematicAreaType::class, $thematicArea);
        $thematicAreaform->handleRequest($request); 
        if ($thematicAreaform->isSubmitted() && $thematicAreaform->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // dd();
           $thematicArea->setCollege($college);
      # $thematicArea->setCreatedAt(new \DateTime());
            $entityManager->persist($thematicArea);
            $entityManager->flush(); 
            return $this->redirectToRoute('college_details');
        }

    $guideline_for_reviewers = $entityManager->getRepository(GuidelineForReviewer::class)->findBy(['college' => $college ] );
  $guidelineForReviewer =$entityManager->getRepository(GuidelineForReviewer::class)->findOneBy(['college' => $college ] );
 if(!$guidelineForReviewer){
    $guidelineForReviewer= new GuidelineForReviewer();
 }
        $formGuidelineForReviewer = $this->createForm(GuidelineForReviewerType::class, $guidelineForReviewer);
        $formGuidelineForReviewer->handleRequest($request);

        if ($formGuidelineForReviewer->isSubmitted() && $formGuidelineForReviewer->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $file3 = $formGuidelineForReviewer->get('attachment')->getData();  
            if (!$file3){ 
            echo ' file not uploaded';
         }   else{
              $file3 = $formGuidelineForReviewer->get('attachment')->getData();  
                   $fileName3 = 'Assessment Guideline  file'.md5(uniqid()).'.'.$file3->guessExtension();  
               $file3->move($this->getParameter('college_guidelines'), $fileName3);  
                $guidelineForReviewer->setAttachment($fileName3); 
                  }
            $evaluationfromf = $formGuidelineForReviewer->get('evaluationfrom')->getData();  
                  if (!$evaluationfromf){ 
                  echo 'File not uploaded';
        }   
        else{
        $evaluationfromf = $formGuidelineForReviewer->get('evaluationfrom')->getData();  
                $file_name = 'Grading Form '.md5(uniqid()).'.'.$evaluationfromf->guessExtension();  
            $evaluationfromf->move($this->getParameter('college_guidelines'), $file_name);  
            $guidelineForReviewer->setEvaluationfrom($file_name); 
            }
#########
            $commentfrom = $formGuidelineForReviewer->get('commentfrom')->getData();  
            if (!$commentfrom){ 
            echo 'File not uploaded';
  }   
  else{
  $commentfrom = $formGuidelineForReviewer->get('commentfrom')->getData();  
          $file_name2 = 'Evaluation Report Form '.md5(uniqid()).'.'.$commentfrom->guessExtension();  
      $commentfrom->move($this->getParameter('college_guidelines'), $file_name2);  
      $guidelineForReviewer->setCommentfrom($file_name2); 
      }

###########
            


            $guidelineForReviewer->setCollege($college);
            $guidelineForReviewer->setCreatedAt(new \DateTime());
            $entityManager->persist($guidelineForReviewer);
            $entityManager->flush();
            return $this->redirectToRoute('college_details');
        }
    
    $guideline =$entityManager->getRepository(Guidelines::class)->findOneBy(['college' => $college ] );
    if(!$guideline){
        $guideline = new Guidelines();   
    }
    $guidelineform = $this->createFormBuilder($guideline)  
         ->add('guideline',   CKEditorType::class,[
            'attr'=>['placeholder'=>'The guideline ',
            'class' => 'form-control col col-md-12 col-sm-12 col-lg-9  ',
                         'required' => false,
        
        ],]) 
 

           ->add('attachment', FileType::class, [
                'label' => 'Guideline for PI  attachment  file',
                'attr'=>[
                    'class' => 'form-control col col-md-12 col-sm-12 col-lg-9  ',
                             'required' => true,
            
            ],
                'mapped' => false, 
                'required' => false,
               
            ])
         ->getForm(); 
        $guidelineform->handleRequest($request);


        if ($guidelineform->isSubmitted() && $guidelineform->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
     $file3 = $guidelineform->get('attachment')->getData();  
           
            // $file3 = $guideline->getAttachment();               
   if ($file3){ 
   echo ' file not uploaded';
}   else{
     $file3 = $guidelineform->get('attachment')->getData();  
          $fileName3 = md5(uniqid()).'.'.$file3->guessExtension();  
      $file3->move($this->getParameter('college_guidelines'), $fileName3);  
     $guideline->setCollege($college);
      $guideline->setCreatedAt(new \DateTime());
           $guideline->setAttachment($fileName3); 
         }
         
        // if ($guidelineform->isSubmitted() && $guidelineform->isValid()) {
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($guideline);
        //     $entityManager->flush();

        //     return $this->redirectToRoute('work_unit_show', array('prefix' => $college->getPrefix()));
        // }
        }
        ///////////////institutiona review board members
        //to be changerd later
            $form = $this->createForm(CollegeType::class, $college);
     $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

             return $this->redirectToRoute('college_details' );
        }            
        return $this->render('college/show.html.twig', [
            'college' => $college,
         'form' => $form->createView(),
        ]);
        
    }



        /**
     * @Route("/{id}/", name="college_show", methods={"GET","POST"})
     */

     public function show(College $college, Request $request,        ): Response
    {
    
    $entityManager = $this->getDoctrine()->getManager();
    $thematicAreas = $entityManager->getRepository(ThematicArea::class)->findBy(['college' => $college ] );
    $guidelines = $entityManager->getRepository(Guidelines::class)->findBy(['college' => $college ] );
    $thematicArea = new ThematicArea();
            $thematicAreaform = $this->createForm(ThematicAreaType::class, $thematicArea);
        $thematicAreaform->handleRequest($request); 
        if ($thematicAreaform->isSubmitted() && $thematicAreaform->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // dd();
           $thematicArea->setCollege($college);
      # $thematicArea->setCreatedAt(new \DateTime());
            $entityManager->persist($thematicArea);
            $entityManager->flush(); 
            return $this->redirectToRoute('college_show', array('id' => $college->getId()));
        }

    $guideline_for_reviewers = $entityManager->getRepository(GuidelineForReviewer::class)->findBy(['college' => $college ] );
  $guidelineForReviewer =$entityManager->getRepository(GuidelineForReviewer::class)->findOneBy(['college' => $college ] );
 if(!$guidelineForReviewer){
    $guidelineForReviewer= new GuidelineForReviewer();
 }
        $formGuidelineForReviewer = $this->createForm(GuidelineForReviewerType::class, $guidelineForReviewer);
        $formGuidelineForReviewer->handleRequest($request);

        if ($formGuidelineForReviewer->isSubmitted() && $formGuidelineForReviewer->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $file3 = $formGuidelineForReviewer->get('attachment')->getData();  
            if (!$file3){ 
            echo ' file not uploaded';
         }   else{
              $file3 = $formGuidelineForReviewer->get('attachment')->getData();  
                   $fileName3 = $formGuidelineForReviewer->get('name')->getData().'-'.md5(uniqid()).'.'.$file3->guessExtension();  
               $file3->move($this->getParameter('college_guidelines'), $fileName3);  
                $guidelineForReviewer->setAttachment($fileName3); 
                  }

                  $evaluationfromf = $formGuidelineForReviewer->get('evaluationfrom')->getData();  
                  if (!$evaluationfromf){ 
                  echo 'File not uploaded';
        }   
        else{
        $evaluationfromf = $formGuidelineForReviewer->get('evaluationfrom')->getData();  
                $file_name = 'Evaluation-form-'.md5(uniqid()).'.'.$evaluationfromf->guessExtension();  
            $evaluationfromf->move($this->getParameter('college_guidelines'), $file_name);  
            $guidelineForReviewer->setEvaluationfrom($file_name); 
            }
#########
            $commentfrom = $formGuidelineForReviewer->get('commentfrom')->getData();  
            if (!$commentfrom){ 
            echo 'File not uploaded';
  }   
  else{
  $commentfrom = $formGuidelineForReviewer->get('commentfrom')->getData();  
          $file_name2 = 'Com-'.md5(uniqid()).'.'.$commentfrom->guessExtension();  
      $commentfrom->move($this->getParameter('college_guidelines'), $file_name2);  
      $guidelineForReviewer->setCommentfrom($file_name2); 
      }

###########
            


            $guidelineForReviewer->setCollege($college);
            $guidelineForReviewer->setCreatedAt(new \DateTime());
            $entityManager->persist($guidelineForReviewer);
            $entityManager->flush();
            return $this->redirectToRoute('college_show', array('id' => $college->getId()));
        }
    
    $guideline =$entityManager->getRepository(Guidelines::class)->findOneBy(['college' => $college ] );
    if(!$guideline){
        $guideline = new Guidelines();   
    }
    $guidelineform = $this->createFormBuilder($guideline)  
         ->add('guideline',   CKEditorType::class,[
            'attr'=>['placeholder'=>'The guideline ',
            'class' => 'form-control col col-md-12 col-sm-12 col-lg-9  ',
                         'required' => false,
        
        ],]) 
 

           ->add('attachment', FileType::class, [
                'label' => 'Guideline for PI  attachment  file',
                'attr'=>[
                    'class' => 'form-control col col-md-12 col-sm-12 col-lg-9  ',
                             'required' => true,
            
            ],
                'mapped' => false, 
                'required' => false,
               
            ])
         ->getForm(); 
        $guidelineform->handleRequest($request);


        if ($guidelineform->isSubmitted() && $guidelineform->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
     $file3 = $guidelineform->get('attachment')->getData();  
           
            // $file3 = $guideline->getAttachment();               
   if ($file3){ 
   echo ' file not uploaded';
}   else{
     $file3 = $guidelineform->get('attachment')->getData();  
          $fileName3 = md5(uniqid()).'.'.$file3->guessExtension();  
      $file3->move($this->getParameter('college_guidelines'), $fileName3);  
     $guideline->setCollege($college);
      $guideline->setCreatedAt(new \DateTime());
           $guideline->setAttachment($fileName3); 
         }
         
        // if ($guidelineform->isSubmitted() && $guidelineform->isValid()) {
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($guideline);
        //     $entityManager->flush();

        //     return $this->redirectToRoute('work_unit_show', array('prefix' => $college->getPrefix()));
        // }
        }
        ///////////////institutiona review board members
        //to be changerd later
            $form = $this->createForm(CollegeType::class, $college);
     $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

             return $this->redirectToRoute('college_show', array('id' => $college->getId()));
        }            
        return $this->render('college/show.html.twig', [
            'college' => $college,
         'form' => $form->createView(),
        ]);
        
    }


    #[Route('/{prefix}/details/', name: 'college_detail', methods: ['GET', 'POST'])]
    public function details(Request $request,  College $college, $prefix): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
   
        //  $collegeinfo='';
    $info = 'All';
    switch ($prefix) {

    case 'jih':
         $request->setlocale('am');
         break;
    default:
        return $this->redirectToRoute('homepage');
 }
    return $this->render('college/showdetails.html.twig', [
            'college' => $college,
         'guidelines' => $guidelines, 
          ]);
    }

    #[Route('/{id}/edit', name: 'college_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, College $college): Response
    {
        $form = $this->createForm(CollegeType::class, $college);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('college_index');
        }

        return $this->render('college/edit.html.twig', [
            'college' => $college,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'college_delete', methods: ['POST'])]
    public function delete(Request $request, College $college): Response
    {
        if ($this->isCsrfTokenValid('delete'.$college->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($college);
            $entityManager->flush();
        }

        return $this->redirectToRoute('college_index');
    }
}
