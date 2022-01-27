<?php

namespace App\Controller;

use App\Entity\SiteSetting;
use App\Form\SiteSettingType;
use App\Repository\SiteSettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Parser;
 
/**
 * @Route("/site")
 */
class SiteSettingController extends AbstractController
{
      /**
          * @Route("/", name="site_setting_index", methods={"GET"})
     */ 
    public function inddex(SiteSettingRepository $siteSettingRepository): Response
    {
        return $this->render('site_setting/index.html.twig', [
            'site_settings' => $siteSettingRepository->findAll(),
        ]);
    }
    


 /**
     * @Route("/new", name="site_setting_new", methods={"GET","POST"})
     */

    public function new(Request $request): Response
    {
        $siteSetting = new SiteSetting();
        $form = $this->createForm(SiteSettingType::class, $siteSetting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($siteSetting);
            $entityManager->flush();

            return $this->redirectToRoute('site_setting_index');
        }

        return $this->render('site_setting/new.html.twig', [
            'site_setting' => $siteSetting,
            'form' => $form->createView(),
        ]);
    }

  /**
 * @Route("/contactus", name="contactus", methods={"GET"})
     */ 
    public function contactus(SiteSetting $siteSetting): Response
    {
                $em = $this->getDoctrine()->getManager();
	  $contactus=$em->$siteSettingRepository->findAll();
        return $this->render('site_setting/contact_us.html.twig', [
            'contactus' => $contactus,
        ]);
    }

  /**
     * @Route("/{id}/edit", name="site_setting_show", methods={"GET","POST"})
     */
 
    public function show(SiteSetting $siteSetting): Response
    {
        return $this->render('site_setting/show.html.twig', [
            'site_setting' => $siteSetting,
        ]);
    }
    
 

  /**
     * @Route("/{id}/settings", name="my_site_setting", methods={"GET","POST"})
     */
 
    public function setmysite(SiteSetting $siteSetting): Response
    {
	$yaml = new Parser();

	$value = $yaml->parse( file_get_contents( get_template_directory() . '/assets/map.yml' ) );

    return $this->render('site_setting/show.html.twig', [
            'site_setting' => $siteSetting,
        ]);
    }




   /**
     * @Route("/{id}/edist", name="site_setting_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SiteSetting $siteSetting): Response
    {
        $form = $this->createForm(SiteSettingType::class, $siteSetting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('site_setting_index');
        }

        return $this->render('site_setting/edit.html.twig', [
            'site_setting' => $siteSetting,
            'form' => $form->createView(),
        ]);
    }

   /**
     * @Route("/{id}/del", name="site_setting_delete", methods={"GET","POST"})
     */
    public function delete(Request $request, SiteSetting $siteSetting): Response
    {
        if ($this->isCsrfTokenValid('delete'.$siteSetting->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($siteSetting);
            $entityManager->flush();
        }

        return $this->redirectToRoute('site_setting_index');
    }
}
