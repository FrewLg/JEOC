<?php

namespace App\Controller;

use App\Entity\EducationalLevel;
use App\Form\EducationalLevelType;
use App\Repository\EducationalLevelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/educational/level')]
class EducationalLevelController extends AbstractController
{
    #[Route('/', name: 'educational_level_index', methods: ['GET'])]
    public function index(EducationalLevelRepository $educationalLevelRepository): Response
    {
        return $this->render('educational_level/index.html.twig', [
            'educational_levels' => $educationalLevelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'educational_level_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $educationalLevel = new EducationalLevel();
        $form = $this->createForm(EducationalLevelType::class, $educationalLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($educationalLevel);
            $entityManager->flush();

            return $this->redirectToRoute('educational_level_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('educational_level/new.html.twig', [
            'educational_level' => $educationalLevel,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'educational_level_show', methods: ['GET'])]
    public function show(EducationalLevel $educationalLevel): Response
    {
        return $this->render('educational_level/show.html.twig', [
            'educational_level' => $educationalLevel,
        ]);
    }

    #[Route('/{id}/edit', name: 'educational_level_edit', methods: ['GET','POST'])]
    public function edit(Request $request, EducationalLevel $educationalLevel): Response
    {
        $form = $this->createForm(EducationalLevelType::class, $educationalLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('educational_level_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('educational_level/edit.html.twig', [
            'educational_level' => $educationalLevel,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'educational_level_delete', methods: ['POST'])]
    public function delete(Request $request, EducationalLevel $educationalLevel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$educationalLevel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($educationalLevel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('educational_level_index', [], Response::HTTP_SEE_OTHER);
    }
}
