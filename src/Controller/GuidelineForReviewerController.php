<?php

namespace App\Controller;

use App\Entity\GuidelineForReviewer;
use App\Form\GuidelineForReviewerType;
use App\Repository\GuidelineForReviewerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/guideline/for/reviewer")
 */
class GuidelineForReviewerController extends AbstractController
{
    /**
     * @Route("/", name="guideline_for_reviewer_index", methods={"GET"})
     */
    public function index(GuidelineForReviewerRepository $guidelineForReviewerRepository): Response
    {
        return $this->render('guideline_for_reviewer/index.html.twig', [
            'guideline_for_reviewers' => $guidelineForReviewerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="guideline_for_reviewer_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $guidelineForReviewer = new GuidelineForReviewer();
        $form = $this->createForm(GuidelineForReviewerType::class, $guidelineForReviewer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($guidelineForReviewer);
            $entityManager->flush();

            return $this->redirectToRoute('guideline_for_reviewer_index');
        }

        return $this->render('guideline_for_reviewer/new.html.twig', [
            'guideline_for_reviewer' => $guidelineForReviewer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="guideline_for_reviewer_show", methods={"GET"})
     */
    public function show(GuidelineForReviewer $guidelineForReviewer): Response
    {
        return $this->render('guideline_for_reviewer/show.html.twig', [
            'guideline_for_reviewer' => $guidelineForReviewer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="guideline_for_reviewer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GuidelineForReviewer $guidelineForReviewer): Response
    {
        $form = $this->createForm(GuidelineForReviewerType::class, $guidelineForReviewer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
           
            $file3 = $form->get('attachment')->getData();  
            if (!$file3){ 
          }   else{
              $file3 = $form->get('attachment')->getData();  
                   $fileName3 = md5(uniqid()).'.'.$file3->guessExtension();  
               $file3->move($this->getParameter('review_files'), $fileName3);  
               $guidelineForReviewer->setAttachment($fileName3); 
 
                  }

                  $evaluationfromf = $form->get('evaluationfrom')->getData();  
                  if (!$evaluationfromf){ 
                  echo 'File not uploaded';
        }   
        else{
        $evaluationfromf = $form->get('evaluationfrom')->getData();  
                $file_name = 'Eval-edited'.md5(uniqid()).'.'.$evaluationfromf->guessExtension();  
            $evaluationfromf->move($this->getParameter('review_files'), $file_name);  
            $guidelineForReviewer->setEvaluationfrom($file_name); 
            }

                  
                  $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('guideline_for_reviewer_index');
        }

        return $this->render('guideline_for_reviewer/edit.html.twig', [
            'guideline_for_reviewer' => $guidelineForReviewer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="guideline_for_reviewer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GuidelineForReviewer $guidelineForReviewer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$guidelineForReviewer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($guidelineForReviewer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('guideline_for_reviewer_index');
    }
}
