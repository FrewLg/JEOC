<?php

namespace App\Controller;

use App\Entity\PublishedSubmission;
use App\Entity\Submission;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File; 
use Symfony\Component\Form\Extension\Core\Type\FileType; 
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateType; 
/**
 * @Route("/publish")
 */
class PublishedController extends AbstractController
{
    
    
    /**
     * @Route("/{uniques}/", name="publication_new", methods={"GET","POST"})
     */
    public function new(Request $request , Submission $submission): Response
    {
        $published = new PublishedSubmission();
          
      	$entityManager = $this->getDoctrine()->getManager(); 
#      	$contributors=$entityManager->getRepository(CoAuthor::class)->findBy(['submission' => $submission ] ); 
     	$form = $this->createFormBuilder($published)  
          ->add('final_report', EntityType::class, array(
                      'placeholder' => '-- Select Attachment Type --',
         'class' => 'App\Entity\AttachementType',
         'attr' => array(
             'empty' => 'Select country ',
             'required' => false,
             'class' => 'chosen-select form-control',
         )
     ))
     ->add('published_date', DateType::class, array(
                  'placeholder' => [
        'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
    ],
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                   'attr' => array(
             'required' => true,
   'class'=>'form-control',
         )
         )) 
     
	  ->add('final_report', FileType::class, [
                'label' => 'Upload your terminal report file', 
                'mapped' => false, 
                'required' => true, 
            ]) 
         ->getForm(); 
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
             $file3 = $published->getFinalReport();   
 
 	if ($file3=''){ 
  	 echo 'File not uploaded';
	}   else{
	 $file3 = $form->get('final_report')->getData();  
          $fileName3 =  md5(uniqid()).'.'.$file3->guessExtension();  
	  $file3->move($this->getParameter('submission_files'), $fileName3);  
           $published->setFinalReport($fileName3); 
         }  
         $published->setSubmission($submission);
            $entityManager->persist($published);
            $entityManager->flush();  
              $this->addFlash(
            'success',
            'Document uploaded successfully!'
        );  
 
        } 
        

        return $this->render('published/publish.html.twig', [
            
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/dataset", name="dataset_new", methods={"GET","POST"})
     */
    public function dataset(Request $request): Response
    {
        $published = new PublishedSubmission();
          
      	$entityManager = $this->getDoctrine()->getManager(); 
#      	$contributors=$entityManager->getRepository(CoAuthor::class)->findBy(['submission' => $submission ] ); 
     	$form = $this->createFormBuilder($published)  
          ->add('final_report', EntityType::class, array(
                      'placeholder' => '-- Select Attachment Type --',
         'class' => 'App\Entity\AttachementType',
         'attr' => array(
             'empty' => 'Select country ',
             'required' => false,
             'class' => 'chosen-select form-control',
         )
     ))
     ->add('published_date', DateType::class, array(
                  'placeholder' => [
        'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
    ],
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                   'attr' => array(
             'required' => true,
   'class'=>'form-control',
         )
         ))  
	  ->add('final_report', FileType::class, [
                'label' => 'Upload your terminal report file', 
                'mapped' => false, 
                'required' => true, 
            ]) 
         ->getForm(); 
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
             $file3 = $published->getFinalReport();   
		$com = $published->getTitle();   
   if ($file3=''){ 
  	 echo 'File not uploaded';
	}   else{
	 $file3 = $form->get('document')->getData();  
          $fileName3 =  md5(uniqid()).'.'.$file3->guessExtension();  
	  $file3->move($this->getParameter('submission_files'), $fileName3);  
           $submission->setDocument($fileName3); 
         }  
         
         if($progress<=10){
                  $submission->setProgress(10);
         }
 
            $entityManager->persist($submission);
            $entityManager->flush();  
              $this->addFlash(
            'success',
            'Document uploaded successfully!'
        );  
            return $this->redirectToRoute('submission_contributors' , array('id' => $submission->getId()));
        } 
        
        

        return $this->render('published/publish.html.twig', [
            
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="co_author_show", methods={"GET"})
     */
    public function show(CoAuthor $coAuthor): Response
    {
        return $this->render('co_author/show.html.twig', [
            'co_author' => $coAuthor,
        ]);
    }

    

    /**
     * @Route("/{id}", name="co_author_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CoAuthor $coAuthor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coAuthor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($coAuthor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('co_author_index');
    }
}
