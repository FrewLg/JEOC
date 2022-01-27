<?php

namespace App\Controller;

use App\Entity\PublishedSubmissionAttachment;
use App\Form\PublishedSubmissionAttachmentType;
use App\Repository\PublishedSubmissionAttachmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/published/submission/attachment')]
class PublishedSubmissionAttachmentController extends AbstractController
{
    #[Route('/', name: 'published_submission_attachment_index', methods: ['GET'])]
    public function index(PublishedSubmissionAttachmentRepository $publishedSubmissionAttachmentRepository): Response
    {
        return $this->render('published_submission_attachment/index.html.twig', [
            'published_submission_attachments' => $publishedSubmissionAttachmentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'published_submission_attachment_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $publishedSubmissionAttachment = new PublishedSubmissionAttachment();
        $form = $this->createForm(PublishedSubmissionAttachmentType::class, $publishedSubmissionAttachment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publishedSubmissionAttachment);
            $entityManager->flush();

            return $this->redirectToRoute('published_submission_attachment_index');
        }

        return $this->render('published_submission_attachment/new.html.twig', [
            'published_submission_attachment' => $publishedSubmissionAttachment,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'published_submission_attachment_show', methods: ['GET'])]
    public function show(PublishedSubmissionAttachment $publishedSubmissionAttachment): Response
    {
        return $this->render('published_submission_attachment/show.html.twig', [
            'published_submission_attachment' => $publishedSubmissionAttachment,
        ]);
    }

    #[Route('/{id}/edit', name: 'published_submission_attachment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PublishedSubmissionAttachment $publishedSubmissionAttachment): Response
    {
        $form = $this->createForm(PublishedSubmissionAttachmentType::class, $publishedSubmissionAttachment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('published_submission_attachment_index');
        }

        return $this->render('published_submission_attachment/edit.html.twig', [
            'published_submission_attachment' => $publishedSubmissionAttachment,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'published_submission_attachment_delete', methods: ['DELETE'])]
    public function delete(Request $request, PublishedSubmissionAttachment $publishedSubmissionAttachment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publishedSubmissionAttachment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($publishedSubmissionAttachment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('published_submission_attachment_index');
    }
}
