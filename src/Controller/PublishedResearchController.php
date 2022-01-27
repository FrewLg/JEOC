<?php

namespace App\Controller;

use App\Entity\PublishedResearch;
use App\Form\PublishedResearchType;
use App\Repository\PublishedResearchRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/published-research')]
class PublishedResearchController extends AbstractController
{
    #[Route('/', name: 'published_research_index', methods: ['GET'])]
    public function index(PublishedResearchRepository $publishedResearchRepository): Response
    {
        return $this->render('published_research/index.html.twig', [
            'published_researches' => $publishedResearchRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'published_research_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $publishedResearch = new PublishedResearch();
        $form = $this->createForm(PublishedResearchType::class, $publishedResearch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publishedResearch);
            $entityManager->flush();

            return $this->redirectToRoute('published_research_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('published_research/new.html.twig', [
            'published_research' => $publishedResearch,
            'submissionform' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'published_research_show', methods: ['GET'])]
    public function show(PublishedResearch $publishedResearch): Response
    {
        return $this->render('published_research/show.html.twig', [
            'published_research' => $publishedResearch,
        ]);
    }

    #[Route('/{id}/edit', name: 'published_research_edit', methods: ['GET','POST'])]
    public function edit(Request $request, PublishedResearch $publishedResearch): Response
    {
        $form = $this->createForm(PublishedResearchType::class, $publishedResearch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('published_research_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('published_research/edit.html.twig', [
            'published_research' => $publishedResearch,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'published_research_delete', methods: ['POST'])]
    public function delete(Request $request, PublishedResearch $publishedResearch): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publishedResearch->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($publishedResearch);
            $entityManager->flush();
        }

        return $this->redirectToRoute('published_research_index', [], Response::HTTP_SEE_OTHER);
    }
}
