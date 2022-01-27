<?php

namespace App\Controller;

use App\Entity\ThematicArea;

use App\Entity\WorkUnit;
use App\Form\ThematicAreaType;
use App\Repository\ThematicAreaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/thematic/area")
 */
class ThematicAreaController extends AbstractController
{
    /**
     * @Route("/", name="thematic_area_index", methods={"GET"})
     */
    public function index(ThematicAreaRepository $thematicAreaRepository): Response
    {
        return $this->render('thematic_area/index.html.twig', [
            'thematic_areas' => $thematicAreaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="thematic_area_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $thematicArea = new ThematicArea();
        $form = $this->createForm(ThematicAreaType::class, $thematicArea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($thematicArea);
            $entityManager->flush();

            return $this->redirectToRoute('thematic_area_index');
        }

        return $this->render('thematic_area/new.html.twig', [
            'thematic_area' => $thematicArea,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="thematic_area_show", methods={"GET"})
     */
    public function show(ThematicArea $thematicArea): Response
    {
        return $this->render('thematic_area/show.html.twig', [
            'thematic_area' => $thematicArea,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="thematic_area_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ThematicArea $thematicArea): Response
    {
        $form = $this->createForm(ThematicAreaType::class, $thematicArea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('thematic_area_index');
        }

        return $this->render('thematic_area/edit.html.twig', [
            'thematic_area' => $thematicArea,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="thematic_area_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ThematicArea $thematicArea): Response
    {
        if ($this->isCsrfTokenValid('delete'.$thematicArea->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($thematicArea);
            $entityManager->flush();
        }

        return $this->redirectToRoute('thematic_area_index');
    }
}
