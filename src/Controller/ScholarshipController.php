<?php

namespace App\Controller;

use App\Entity\Scholarship;
use App\Form\ScholarshipType;
use App\Repository\ScholarshipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


#[Route('/scholarship')]
class ScholarshipController extends AbstractController
{
    #[Route('/adm', name: 'scholarship_index_adm', methods: ['GET'])]
    public function admindex(ScholarshipRepository $scholarshipRepository): Response
    {
        return $this->render('scholarship/index.html.twig', [
            'scholarships' => $scholarshipRepository->findAll(),
        ]);
    }

    #[Route('/', name: 'scholarship_index', methods: ['GET'])]
    public function index(Request $request,ScholarshipRepository $scholarshipRepository ,PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();

        $scholarshipRepository = array_reverse($em->getRepository('App:Scholarship')->findAll()); 

        $scholarships = $paginator->paginate(
            // Doctrine Query, not results
            $scholarshipRepository,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        ); 

        return $this->render('scholarship/all-scholarships.html.twig', [
            'Scholarships' => $scholarships,
        ]);
    }


    
    #[Route('/new', name: 'scholarship_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        
        $scholarship = new Scholarship();
        $form = $this->createForm(ScholarshipType::class, $scholarship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
          $scholarship->setCreatedAt(new \DateTime());

            $entityManager->persist($scholarship);
            $entityManager->flush();

            return $this->redirectToRoute('scholarship_index');
        }

        return $this->render('scholarship/new.html.twig', [
            'scholarship' => $scholarship,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'scholarship_show', methods: ['GET'])]
    public function show(Scholarship $scholarship): Response
    {
        return $this->render('scholarship/show.html.twig', [
            'scholarship' => $scholarship,
        ]);
    }

    #[Route('/{id}/edit', name: 'scholarship_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Scholarship $scholarship): Response
    {
        $form = $this->createForm(ScholarshipType::class, $scholarship);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('scholarship_index');
        }

        return $this->render('scholarship/edit.html.twig', [
            'scholarship' => $scholarship,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'scholarship_delete', methods: ['POST'])]
    public function delete(Request $request, Scholarship $scholarship): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scholarship->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($scholarship);
            $entityManager->flush();
        }

        return $this->redirectToRoute('scholarship_index');
    }
}
