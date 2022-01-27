<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(TranslatorInterface $translator): Response
    {
 
        $message = $translator->trans('text.message',[], null, 'am');
  return $this->render('home/index.html.twig', [
            'message' => $message
        ]);
    }
}
