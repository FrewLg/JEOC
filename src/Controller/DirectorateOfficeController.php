<?php

namespace App\Controller;

use App\Entity\DirectorateOffice;
use App\Form\DirectorateOfficeType;
use App\Repository\DirectorateOfficeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/directorate")
 */
class DirectorateOfficeController extends AbstractController
{
    /**
     * @Route("/", name="directorate_office_index", methods={"GET"})
     */
    public function index(DirectorateOfficeRepository $directorateOfficeRepository): Response
    {
        return $this->render('directorate_office/index.html.twig', [
            'directorate_offices' => $directorateOfficeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="directorate_office_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $directorateOffice = new DirectorateOffice();
        $form = $this->createForm(DirectorateOfficeType::class, $directorateOffice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($directorateOffice);
            $entityManager->flush();

            return $this->redirectToRoute('directorate_office_index');
        }

        return $this->render('directorate_office/new.html.twig', [
            'directorate_office' => $directorateOffice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="directorate_office_show", methods={"GET"})
     */
    public function show(DirectorateOffice $directorateOffice): Response
    {
        return $this->render('directorate_office/show.html.twig', [
            'directorate_office' => $directorateOffice,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="directorate_office_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DirectorateOffice $directorateOffice): Response
    {
        $form = $this->createForm(DirectorateOfficeType::class, $directorateOffice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('directorate_office_index');
        }

        return $this->render('directorate_office/edit.html.twig', [
            'directorate_office' => $directorateOffice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="directorate_office_delete", methods={"POST"})
     */
    public function delete(Request $request, DirectorateOffice $directorateOffice): Response
    {
        if ($this->isCsrfTokenValid('delete'.$directorateOffice->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($directorateOffice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('directorate_office_index');
    }
}
