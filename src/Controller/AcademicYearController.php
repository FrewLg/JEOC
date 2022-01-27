<?php

namespace App\Controller;

use App\Entity\AcademicYear;
use App\Form\AcademicYearType;
use App\Repository\AcademicYearRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/academic-year')]
class AcademicYearController extends AbstractController
{
    #[Route('/', name: 'academic_year_index', methods: ['GET'])]
    public function index(AcademicYearRepository $academicYearRepository): Response
    {
        return $this->render('academic_year/index.html.twig', [
            'academic_years' => $academicYearRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'academic_year_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $academicYear = new AcademicYear();
        $form = $this->createForm(AcademicYearType::class, $academicYear);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($academicYear);
            $entityManager->flush();

            return $this->redirectToRoute('academic_year_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('academic_year/new.html.twig', [
            'academic_year' => $academicYear,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'academic_year_show', methods: ['GET'])]
    public function show(AcademicYear $academicYear): Response
    {
        return $this->render('academic_year/show.html.twig', [
            'academic_year' => $academicYear,
        ]);
    }

    #[Route('/{id}/edit', name: 'academic_year_edit', methods: ['GET','POST'])]
    public function edit(Request $request, AcademicYear $academicYear): Response
    {
        $form = $this->createForm(AcademicYearType::class, $academicYear);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('academic_year_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('academic_year/edit.html.twig', [
            'academic_year' => $academicYear,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'academic_year_delete', methods: ['POST'])]
    public function delete(Request $request, AcademicYear $academicYear): Response
    {
        if ($this->isCsrfTokenValid('delete'.$academicYear->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($academicYear);
            $entityManager->flush();
        }

        return $this->redirectToRoute('academic_year_index', [], Response::HTTP_SEE_OTHER);
    }
}
