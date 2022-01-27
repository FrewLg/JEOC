<?php

namespace App\Controller;

use App\Entity\EvaluationFormOption;
use App\Form\EvaluationFormOptionType;
use App\Repository\EvaluationFormOptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evaluation-form-option")
 */
class EvaluationFormOptionController extends AbstractController
{
    /**
     * @Route("/", name="evaluation_form_option_index", methods={"GET"})
     */
    public function index(EvaluationFormOptionRepository $evaluationFormOptionRepository): Response
    {
        return $this->render('evaluation_form_option/index.html.twig', [
            'evaluation_form_options' => $evaluationFormOptionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="evaluation_form_option_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evaluationFormOption = new EvaluationFormOption();
        $form = $this->createForm(EvaluationFormOptionType::class, $evaluationFormOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evaluationFormOption);
            $entityManager->flush();

            return $this->redirectToRoute('evaluation_form_option_index');
        }

        return $this->render('evaluation_form_option/new.html.twig', [
            'evaluation_form_option' => $evaluationFormOption,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evaluation_form_option_show", methods={"GET"})
     */
    public function show(EvaluationFormOption $evaluationFormOption): Response
    {
        return $this->render('evaluation_form_option/show.html.twig', [
            'evaluation_form_option' => $evaluationFormOption,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evaluation_form_option_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EvaluationFormOption $evaluationFormOption): Response
    {
        $form = $this->createForm(EvaluationFormOptionType::class, $evaluationFormOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evaluation_form_option_index');
        }

        return $this->render('evaluation_form_option/edit.html.twig', [
            'evaluation_form_option' => $evaluationFormOption,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evaluation_form_option_delete", methods={"POST"})
     */
    public function delete(Request $request, EvaluationFormOption $evaluationFormOption): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evaluationFormOption->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evaluationFormOption);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evaluation_form_option_index');
    }
}
