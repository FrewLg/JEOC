<?php

namespace App\Controller;

use App\Entity\EditorialDecision;
use App\Form\EditorialDecisionType;
use App\Repository\EditorialDecisionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/editorial/decision")
 */
class EditorialDecisionController extends AbstractController
{
    /**
     * @Route("/", name="editorial_decision_index", methods={"GET"})
     */
    public function index(EditorialDecisionRepository $editorialDecisionRepository): Response
    {
        return $this->render('editorial_decision/index.html.twig', [
            'editorial_decisions' => $editorialDecisionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="editorial_decision_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $editorialDecision = new EditorialDecision();
        $form = $this->createForm(EditorialDecisionType::class, $editorialDecision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($editorialDecision);
            $entityManager->flush();

            return $this->redirectToRoute('editorial_decision_index');
        }

        return $this->render('editorial_decision/new.html.twig', [
            'editorial_decision' => $editorialDecision,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="editorial_decision_show", methods={"GET"})
     */
    public function show(EditorialDecision $editorialDecision): Response
    {
        return $this->render('editorial_decision/show.html.twig', [
            'editorial_decision' => $editorialDecision,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="editorial_decision_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EditorialDecision $editorialDecision): Response
    {
        $form = $this->createForm(EditorialDecisionType::class, $editorialDecision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('editorial_decision_index');
        }

        return $this->render('editorial_decision/edit.html.twig', [
            'editorial_decision' => $editorialDecision,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="editorial_decision_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EditorialDecision $editorialDecision): Response
    {
        if ($this->isCsrfTokenValid('delete'.$editorialDecision->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($editorialDecision);
            $entityManager->flush();
        }

        return $this->redirectToRoute('editorial_decision_index');
    }
}
