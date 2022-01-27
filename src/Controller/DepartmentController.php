<?php

namespace App\Controller;

use App\Entity\Department;
use App\Form\DepartmentType;
use App\Repository\DepartmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/department')]
class DepartmentController extends AbstractController
{
    #[Route('/', name: 'department_index', methods: ['GET'])]
    public function index(DepartmentRepository $departmentRepository): Response
    {
    $this->denyAccessUnlessGranted('assn_clg_cntr');

        return $this->render('department/index.html.twig', [
            'departments' => $departmentRepository->findBy(['college'=>$this->getUser()->getUserInfo()->getCollege()]),
        ]);
    }

    #[Route('/new', name: 'department_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
    $this->denyAccessUnlessGranted('assn_clg_cntr');

        $department = new Department();
        $form = $this->createForm(DepartmentType::class, $department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($department);
            $entityManager->flush();

            return $this->redirectToRoute('department_index');
        }

        return $this->render('department/new.html.twig', [
            'department' => $department,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'department_show', methods: ['GET'])]
    public function show(Department $department): Response
    {
    $this->denyAccessUnlessGranted('assn_clg_cntr');

        return $this->render('department/show.html.twig', [
            'department' => $department,
        ]);
    }

    #[Route('/{id}/edit', name: 'department_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Department $department): Response
    {
    $this->denyAccessUnlessGranted('assn_clg_cntr');

        $form = $this->createForm(DepartmentType::class, $department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('department_index');
        }

        return $this->render('department/edit.html.twig', [
            'department' => $department,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'department_delete', methods: ['POST'])]
    public function delete(Request $request, Department $department): Response
    {
    $this->denyAccessUnlessGranted('assn_clg_cntr');

        if ($this->isCsrfTokenValid('delete'.$department->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($department);
            $entityManager->flush();
        }

        return $this->redirectToRoute('department_index');
    }
}
