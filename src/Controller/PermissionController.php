<?php

namespace App\Controller;

use App\Entity\Permission;
use App\Form\PermissionType;
use App\Repository\PermissionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/permission")
 */
class PermissionController extends AbstractController
{
    /**
     * @Route("/", name="permission_index", methods={"GET","POST"})
     */
    public function index(PermissionRepository $permissionRepository, Request $request,  PaginatorInterface $paginator): Response
    {
        
        $this->denyAccessUnlessGranted('perm_act');
        
        $queryBuilder=$permissionRepository->getData($request->query->get('search'));
        $data=$paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page',1),
            10
        );

        return $this->render('permission/index.html.twig', [
            'permissions' => $data,
        ]);
    }

    /**
     * @Route("/new", name="permission_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $this->denyAccessUnlessGranted('perm_act');

        $permission = new Permission();
        $form = $this->createForm(PermissionType::class, $permission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($permission);
            $entityManager->flush();

            $this->addFlash("success","Permission Saved!!");
            return $this->redirectToRoute('permission_index');
        }

        return $this->render('permission/new.html.twig', [
            'permission' => $permission,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="permission_show", methods={"GET"})
     */
    public function show(Permission $permission): Response
    {

        $this->denyAccessUnlessGranted('perm_act');

        return $this->render('permission/show.html.twig', [
            'permission' => $permission,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="permission_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Permission $permission): Response
    {

        $this->denyAccessUnlessGranted('perm_act');

        $form = $this->createForm(PermissionType::class, $permission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('permission_index');
        }

        return $this->render('permission/edit.html.twig', [
            'permission' => $permission,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="permission_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Permission $permission): Response
    {

        $this->denyAccessUnlessGranted('perm_act');
        
        if ($this->isCsrfTokenValid('delete'.$permission->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($permission);
            $entityManager->flush();
        }

        return $this->redirectToRoute('permission_index');
    }
}