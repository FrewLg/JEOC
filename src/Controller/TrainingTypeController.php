<?php

namespace App\Controller;

use App\Entity\TrainingType;
use App\Form\TrainingTypeType;
use App\Repository\TrainingTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/training-type')]
class TrainingTypeController extends AbstractController
{
    #[Route('/', name: 'training_type_index', methods: ['GET'])]
    public function index(TrainingTypeRepository $trainingTypeRepository): Response
    {
        return $this->render('training_type/index.html.twig', [
            'training_types' => $trainingTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'training_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trainingType = new TrainingType();
        $form = $this->createForm(TrainingTypeType::class, $trainingType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trainingType);
            $entityManager->flush();

            return $this->redirectToRoute('training_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('training_type/new.html.twig', [
            'training_type' => $trainingType,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'training_type_show', methods: ['GET'])]
    public function show(TrainingType $trainingType): Response
    {
        return $this->render('training_type/show.html.twig', [
            'training_type' => $trainingType,
        ]);
    }

    #[Route('/{id}/edit', name: 'training_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TrainingType $trainingType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TrainingTypeType::class, $trainingType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('training_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('training_type/edit.html.twig', [
            'training_type' => $trainingType,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'training_type_delete', methods: ['POST'])]
    public function delete(Request $request, TrainingType $trainingType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trainingType->getId(), $request->request->get('_token'))) {
            $entityManager->remove($trainingType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('training_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
