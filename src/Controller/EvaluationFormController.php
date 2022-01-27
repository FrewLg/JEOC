<?php

namespace App\Controller;

use App\Entity\EvaluationForm;
use App\Form\EvaluationFormType;
use App\Repository\EvaluationFormRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evaluation-form")
 */
class EvaluationFormController extends AbstractController
{
    /**
     * @Route("/", name="evaluation_form_index", methods={"GET"})
     */
    public function index(EvaluationFormRepository $evaluationFormRepository): Response
    {
        return $this->render('evaluation_form/index.html.twig', [
            'evaluation_forms' => $evaluationFormRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="evaluation_form_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evaluationForm = new EvaluationForm();
        $form = $this->createForm(EvaluationFormType::class, $evaluationForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evaluationForm);
            $entityManager->flush();

            return $this->redirectToRoute('evaluation_form_index');
        }

        return $this->render('evaluation_form/new.html.twig', [
            'evaluation_form' => $evaluationForm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evaluation_form_show", methods={"GET"})
     */
    public function show(EvaluationForm $evaluationForm): Response
    {
        return $this->render('evaluation_form/show.html.twig', [
            'evaluation_form' => $evaluationForm,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evaluation_form_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EvaluationForm $evaluationForm): Response
    {
        $form = $this->createForm(EvaluationFormType::class, $evaluationForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evaluation_form_index');
        }

        return $this->render('evaluation_form/edit.html.twig', [
            'evaluation_form' => $evaluationForm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evaluation_form_delete", methods={"POST"})
     */
    public function delete(Request $request, EvaluationForm $evaluationForm): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evaluationForm->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evaluationForm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evaluation_form_index');
    }
}
