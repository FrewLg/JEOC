<?php

namespace App\Controller;

use App\Entity\SubmissionBudgetCategory;
use App\Form\SubmissionBudgetCategoryType;
use App\Repository\SubmissionBudgetCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/submission/budget/category')]
class SubmissionBudgetCategoryController extends AbstractController
{
    #[Route('/', name: 'submission_budget_category_index', methods: ['GET'])]
    public function index(SubmissionBudgetCategoryRepository $submissionBudgetCategoryRepository): Response
    {
        return $this->render('submission_budget_category/index.html.twig', [
            'submission_budget_categories' => $submissionBudgetCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'submission_budget_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $submissionBudgetCategory = new SubmissionBudgetCategory();
        $form = $this->createForm(SubmissionBudgetCategoryType::class, $submissionBudgetCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($submissionBudgetCategory);
            $entityManager->flush();

            return $this->redirectToRoute('submission_budget_category_index');
        }

        return $this->render('submission_budget_category/new.html.twig', [
            'submission_budget_category' => $submissionBudgetCategory,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'submission_budget_category_show', methods: ['GET'])]
    public function show(SubmissionBudgetCategory $submissionBudgetCategory): Response
    {
        return $this->render('submission_budget_category/show.html.twig', [
            'submission_budget_category' => $submissionBudgetCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'submission_budget_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SubmissionBudgetCategory $submissionBudgetCategory): Response
    {
        $form = $this->createForm(SubmissionBudgetCategoryType::class, $submissionBudgetCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('submission_budget_category_index');
        }

        return $this->render('submission_budget_category/edit.html.twig', [
            'submission_budget_category' => $submissionBudgetCategory,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'submission_budget_category_delete', methods: ['POST'])]
    public function delete(Request $request, SubmissionBudgetCategory $submissionBudgetCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$submissionBudgetCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($submissionBudgetCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('submission_budget_category_index');
    }
}
