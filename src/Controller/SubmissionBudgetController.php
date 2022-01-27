<?php

namespace App\Controller;

use App\Entity\SubmissionBudget;
use App\Form\SubmissionBudgetType;
use App\Repository\SubmissionBudgetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/submission/budget")
 */
class SubmissionBudgetController extends AbstractController
{
    /**
     * @Route("/", name="submission_budget_index", methods={"GET"})
     */
    public function index(SubmissionBudgetRepository $submissionBudgetRepository): Response
    {
        return $this->render('submission_budget/index.html.twig', [
            'submission_budgets' => $submissionBudgetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="submission_budget_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $submissionBudget = new SubmissionBudget();
        $form = $this->createForm(SubmissionBudgetType::class, $submissionBudget);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($submissionBudget);
            $entityManager->flush();

            return $this->redirectToRoute('submission_budget_index');
        }

        return $this->render('submission_budget/new.html.twig', [
            'submission_budget' => $submissionBudget,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="submission_budget_show", methods={"GET"})
     */
    public function show(SubmissionBudget $submissionBudget): Response
    {
        return $this->render('submission_budget/show.html.twig', [
            'submission_budget' => $submissionBudget,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="submission_budget_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SubmissionBudget $submissionBudget): Response
    {
        $form = $this->createForm(SubmissionBudgetType::class, $submissionBudget);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('submission_budget_index');
        }

        return $this->render('submission_budget/edit.html.twig', [
            'submission_budget' => $submissionBudget,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="submission_budget_delete", methods={"POST"})
     */
    public function delete(Request $request, SubmissionBudget $submissionBudget): Response
    {
        if ($this->isCsrfTokenValid('delete'.$submissionBudget->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($submissionBudget);
            $entityManager->flush();
        }

        return $this->redirectToRoute('submission_budget_index');
    }
}
