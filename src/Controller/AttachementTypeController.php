<?php

namespace App\Controller;

use App\Entity\AttachementType;
use App\Form\AttachementTypeType;
use App\Repository\AttachementTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/attachement/type")
 */
class AttachementTypeController extends AbstractController
{
    /**
     * @Route("/", name="attachement_type_index", methods={"GET"})
     */
    public function index(AttachementTypeRepository $attachementTypeRepository): Response
    {
        return $this->render('attachement_type/index.html.twig', [
            'attachement_types' => $attachementTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="attachement_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $attachementType = new AttachementType();
        $form = $this->createForm(AttachementTypeType::class, $attachementType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($attachementType);
            $entityManager->flush();

            return $this->redirectToRoute('attachement_type_index');
        }

        return $this->render('attachement_type/new.html.twig', [
            'attachement_type' => $attachementType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="attachement_type_show", methods={"GET"})
     */
    public function show(AttachementType $attachementType): Response
    {
        return $this->render('attachement_type/show.html.twig', [
            'attachement_type' => $attachementType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="attachement_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AttachementType $attachementType): Response
    {
        $form = $this->createForm(AttachementTypeType::class, $attachementType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attachement_type_index');
        }

        return $this->render('attachement_type/edit.html.twig', [
            'attachement_type' => $attachementType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="attachement_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AttachementType $attachementType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attachementType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($attachementType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('attachement_type_index');
    }
}
