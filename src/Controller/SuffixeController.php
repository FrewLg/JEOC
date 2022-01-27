<?php

namespace App\Controller;

use App\Entity\Suffixe;
use App\Form\SuffixeType;
use App\Repository\SuffixeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/suffixe')]
class SuffixeController extends AbstractController
{
    #[Route('/', name: 'suffixe_index', methods: ['GET'])]
    public function index(SuffixeRepository $suffixeRepository): Response
    {
        return $this->render('suffixe/index.html.twig', [
            'suffixes' => $suffixeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'suffixe_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $suffixe = new Suffixe();
        $form = $this->createForm(SuffixeType::class, $suffixe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($suffixe);
            $entityManager->flush();

            return $this->redirectToRoute('suffixe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('suffixe/new.html.twig', [
            'suffixe' => $suffixe,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'suffixe_show', methods: ['GET'])]
    public function show(Suffixe $suffixe): Response
    {
        return $this->render('suffixe/show.html.twig', [
            'suffixe' => $suffixe,
        ]);
    }

    #[Route('/{id}/edit', name: 'suffixe_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Suffixe $suffixe): Response
    {
        $form = $this->createForm(SuffixeType::class, $suffixe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('suffixe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('suffixe/edit.html.twig', [
            'suffixe' => $suffixe,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'suffixe_delete', methods: ['POST'])]
    public function delete(Request $request, Suffixe $suffixe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$suffixe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($suffixe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('suffixe_index', [], Response::HTTP_SEE_OTHER);
    }
}
