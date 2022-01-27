<?php

namespace App\Controller;

use App\Entity\UserGroup;
use App\Form\UserGroupType;
use App\Repository\PermissionRepository;
use App\Repository\UserGroupRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user-group")
 */
class UserGroupController extends AbstractController
{
    /**
     * @Route("/", name="user_group_index", methods={"GET"})
     */
    public function index(UserGroupRepository $userGroupRepository): Response
    {

         
        $this->denyAccessUnlessGranted('usrgrp_act');


        
        return $this->render('user_group/index.html.twig', [
            'user_groups' => $userGroupRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_group_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('usrgrp_act');



        $userGroup = new UserGroup();
        $form = $this->createForm(UserGroupType::class, $userGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
$userGroup->setRegisteredBy($this->getUser());
            $entityManager->persist($userGroup);

            $userGroup->setCreatedAt(new DateTime('now'));
            $entityManager->flush();

            $this->addFlash("success","User Group Created Successfully!!");

            return $this->redirectToRoute('user_group_users',['id'=>$userGroup->getId()]);
        }

        return $this->render('user_group/new.html.twig', [
            'user_group' => $userGroup,
            'form' => $form->createView(),
            
        ]);
    }
          /**
     * @Route("/{id}/permission", name="user_group_permission", methods={"GET","POST"})
     */
    public function permission(UserGroup $userGroup,Request $request,PermissionRepository $permissionRepository){
        
        $this->denyAccessUnlessGranted('ad_prmsn_to_grp');

       if($request->request->get('usergrouppermission')){
           $permissions=$permissionRepository->findAll();
              foreach ($permissions as $permission) {
            $userGroup->removePermission($permission);
           }

           $permissions=$permissionRepository->findBy(['id'=>$request->request->get('permission')]);
           foreach ($permissions as $permission) {
              
            $userGroup->addPermission($permission);
           }
         
           $userGroup->setUpdatedAt(new \DateTime());
           $userGroup->setUpdatedBy($this->getUser());
           $this->getDoctrine()->getManager()->flush();
       }
        return $this->render('user_group/show.html.twig', [
            'user_group' => $userGroup,
            'permissions' => $permissionRepository->findForUserGroup($userGroup->getPermission()),
           
        ]);
 

}
      /**
     * @Route("/{id}/users", name="user_group_users")
     */
    public function user(UserGroup $userGroup,Request $request,UserRepository $userRepository){
        $this->denyAccessUnlessGranted('ad_usr_to_grp');

       if($request->request->get('usergroupuser')){
           $users=$userGroup->getUsers();
              foreach ($users as $user) {
            $userGroup->removeUser($user);
           }
           
           $users=$userRepository->findBy(['id'=>$request->request->get('user')]);
           foreach ($users as $user) {
            $userGroup->addUser($user);
           }
           $userGroup->setUpdatedAt(new \DateTime());
           $userGroup->setUpdatedBy($this->getUser());
           $this->getDoctrine()->getManager()->flush();
       }
        return $this->render('user_group/add.user.html.twig', [
            'user_group' => $userGroup,
            'users' => $userRepository->findForUserGroup($userGroup->getUsers()),
           
        ]);
 

}

    /**
     * @Route("/{id}", name="user_group_show", methods={"GET"})
     */
    public function show(UserGroup $userGroup): Response
    {
        $this->denyAccessUnlessGranted('usrgrp_act');



        return $this->render('user_group/show.html.twig', [
            'user_group' => $userGroup,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_group_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserGroup $userGroup): Response
    {
        $this->denyAccessUnlessGranted('usrgrp_act');



        $form = $this->createForm(UserGroupType::class, $userGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userGroup->setUpdatedAt(new DateTime('now'));
            $this->getDoctrine()->getManager()->flush();


            $this->addFlash("success","Updated Successfully!!");

            return $this->redirectToRoute('user_group_index');
        }

        return $this->render('user_group/edit.html.twig', [
            'user_group' => $userGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_group_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserGroup $userGroup): Response
    {
        $this->denyAccessUnlessGranted('usrgrp_act');


        if ($this->isCsrfTokenValid('delete'.$userGroup->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userGroup);
            $entityManager->flush();

            $this->addFlash("success","Removed Successfully!!");
        }

        return $this->redirectToRoute('user_group_index');
    }
}
