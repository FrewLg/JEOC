<?php

namespace App\Controller;

use App\Entity\Guidelines;
use App\Form\GuidelinesType;
use App\Repository\GuidelinesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/guidelines")
 */
class GuidelinesController extends AbstractController
{
    /**
     * @Route("/", name="guidelines_index", methods={"GET"})
     */
    public function index(GuidelinesRepository $guidelinesRepository): Response
    {
        return $this->render('guidelines/index.html.twig', [
            'guidelines' => $guidelinesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="guidelines_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $guideline = new Guidelines();
        $form = $this->createForm(GuidelinesType::class, $guideline);
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($guideline);
            $entityManager->flush(); 
            return $this->redirectToRoute('guidelines_index');
        }
        return $this->render('guidelines/new.html.twig', [
            'guideline' => $guideline,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="guidelines_show", methods={"GET"})
     */
    public function show(Guidelines $guideline): Response
    {
        return $this->render('guidelines/show.html.twig', [
            'guideline' => $guideline,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="guidelines_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Guidelines $guideline): Response
    {
        $form = $this->createForm(GuidelinesType::class, $guideline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('guidelines_index');
        }

        return $this->render('guidelines/edit.html.twig', [
            'guideline' => $guideline,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="guidelines_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Guidelines $guideline): Response
    {
        if ($this->isCsrfTokenValid('delete'.$guideline->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($guideline);
            $entityManager->flush();
        }

        return $this->redirectToRoute('guidelines_index');
    }
}
