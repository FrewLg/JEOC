<?php

namespace App\Controller;

use App\Entity\CollaboratingInstitution;
use App\Form\CollaboratingInstitutionType;
use App\Repository\CollaboratingInstitutionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/collaborating/institution")
 */
class CollaboratingInstitutionController extends AbstractController
{
    /**
     * @Route("/", name="collaborating_institution_index", methods={"GET"})
     */
    public function index(CollaboratingInstitutionRepository $collaboratingInstitutionRepository): Response
    {
        return $this->render('collaborating_institution/index.html.twig', [
            'collaborating_institutions' => $collaboratingInstitutionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="collaborating_institution_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $collaboratingInstitution = new CollaboratingInstitution();
        $form = $this->createForm(CollaboratingInstitutionType::class, $collaboratingInstitution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($collaboratingInstitution);
            $entityManager->flush();

            return $this->redirectToRoute('collaborating_institution_index');
        }

        return $this->render('collaborating_institution/new.html.twig', [
            'collaborating_institution' => $collaboratingInstitution,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collaborating_institution_show", methods={"GET"})
     */
    public function show(CollaboratingInstitution $collaboratingInstitution): Response
    {
        return $this->render('collaborating_institution/show.html.twig', [
            'collaborating_institution' => $collaboratingInstitution,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="collaborating_institution_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CollaboratingInstitution $collaboratingInstitution): Response
    {
        $form = $this->createForm(CollaboratingInstitutionType::class, $collaboratingInstitution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('collaborating_institution_index');
        }

        return $this->render('collaborating_institution/edit.html.twig', [
            'collaborating_institution' => $collaboratingInstitution,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collaborating_institution_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CollaboratingInstitution $collaboratingInstitution): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collaboratingInstitution->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($collaboratingInstitution);
            $entityManager->flush();
        }

        return $this->redirectToRoute('collaborating_institution_index');
    }
}
