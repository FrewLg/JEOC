<?php

namespace App\Controller;

use App\Entity\BackupSetting;
use App\Form\BackupSettingType;
use App\Repository\BackupSettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backup/setting")
 */
class BackupSettingController extends AbstractController
{
    /**
     * @Route("/", name="backup_setting_index", methods={"GET"})
     */
    public function index(BackupSettingRepository $backupSettingRepository): Response
    {
        return $this->render('backup_setting/index.html.twig', [
            'backup_settings' => $backupSettingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="backup_setting_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $backupSetting = new BackupSetting();
        $form = $this->createForm(BackupSettingType::class, $backupSetting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($backupSetting);
            $entityManager->flush();

            return $this->redirectToRoute('backup_setting_index');
        }

        return $this->render('backup_setting/new.html.twig', [
            'backup_setting' => $backupSetting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backup_setting_show", methods={"GET"})
     */
    public function show(BackupSetting $backupSetting): Response
    {
        return $this->render('backup_setting/show.html.twig', [
            'backup_setting' => $backupSetting,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="backup_setting_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BackupSetting $backupSetting): Response
    {
        $form = $this->createForm(BackupSettingType::class, $backupSetting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backup_setting_index');
        }

        return $this->render('backup_setting/edit.html.twig', [
            'backup_setting' => $backupSetting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backup_setting_delete", methods={"POST"})
     */
    public function delete(Request $request, BackupSetting $backupSetting): Response
    {
        if ($this->isCsrfTokenValid('delete'.$backupSetting->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($backupSetting);
            $entityManager->flush();
        }

        return $this->redirectToRoute('backup_setting_index');
    }
}
