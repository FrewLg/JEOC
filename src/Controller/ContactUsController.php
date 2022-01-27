<?php

namespace App\Controller;

use App\Entity\ContactUs;
use App\Form\ContactUsType;
use App\Repository\ContactUsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
/**
 * @Route("/contact-us")
 */
class ContactUsController extends AbstractController
{
    /**
     * @Route("/", name="contact_us_index", methods={"GET"})
     */
    public function index(ContactUsRepository $contactUsRepository): Response
    {
        return $this->render('contact_us/index.html.twig', [
            'contactuses' => $contactUsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contact_us_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $contactU = new ContactUs();
        $form = $this->createFormBuilder($contactU)
    
         ->add('name' , TextType::class, [
            'attr' => [
                'placeholder' => 'Name',
                'required' => true,
                'class' => 'form-control',
            ]])
            
         ->add('email'  , EmailType::class, [
            'attr' => [
                'placeholder' => 'Email',
                'required' => true,
                'class' => 'form-control',
            ]]) 
          ->add('subject' , TextType::class, [
            'attr' => [
                'placeholder' => 'Subject',
                'required' => true,
                'class' => 'form-control',
            ]])
          ->add('message',  TextareaType::class,[
    
    'attr'=>['placeholder'=>'Your message ',
    'class' => 'form-control',
    'required' => false, 
           ],])  
           ->getForm(); 
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contactU);
            $entityManager->flush();
//dd($contactU);
            return $this->redirectToRoute('contact_us_new');
        }

        return $this->render('contact_us/new.html.twig', [
            'contact_u' => $contactU,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_us_show", methods={"GET"})
     */
    public function show(ContactUs $contactU): Response
    {
        return $this->render('contact_us/show.html.twig', [
            'contact_u' => $contactU,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contact_us_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ContactUs $contactU): Response
    {
        $form = $this->createForm(ContactUsType::class, $contactU);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_us_index');
        }

        return $this->render('contact_us/edit.html.twig', [
            'contact_u' => $contactU,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_us_delete", methods={"POST"})
     */
    public function delete(Request $request, ContactUs $contactU): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contactU->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contactU);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contact_us_index');
    }
}
