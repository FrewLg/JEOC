<?php

namespace App\Controller;

use App\Entity\AcademicRank;
use App\Form\AcademicRankType;
use App\Repository\AcademicRankRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/academic/rank')]
class AcademicRankController extends AbstractController
{
    #[Route('/', name: 'academic_rank_index', methods: ['GET'])]
    public function index(AcademicRankRepository $academicRankRepository): Response
    {
        return $this->render('academic_rank/index.html.twig', [
            'academic_ranks' => $academicRankRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'academic_rank_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $academicRank = new AcademicRank();
        $form = $this->createForm(AcademicRankType::class, $academicRank);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($academicRank);
            $entityManager->flush();

            return $this->redirectToRoute('academic_rank_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('academic_rank/new.html.twig', [
            'academic_rank' => $academicRank,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'academic_rank_show', methods: ['GET'])]
    public function show(AcademicRank $academicRank): Response
    {
        return $this->render('academic_rank/show.html.twig', [
            'academic_rank' => $academicRank,
        ]);
    }

    #[Route('/{id}/edit', name: 'academic_rank_edit', methods: ['GET','POST'])]
    public function edit(Request $request, AcademicRank $academicRank): Response
    {
        $form = $this->createForm(AcademicRankType::class, $academicRank);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('academic_rank_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('academic_rank/edit.html.twig', [
            'academic_rank' => $academicRank,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'academic_rank_delete', methods: ['POST'])]
    public function delete(Request $request, AcademicRank $academicRank): Response
    {
        if ($this->isCsrfTokenValid('delete'.$academicRank->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($academicRank);
            $entityManager->flush();
        }

        return $this->redirectToRoute('academic_rank_index', [], Response::HTTP_SEE_OTHER);
    }
}
