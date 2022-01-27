<?php

namespace App\Controller;

use App\Entity\EmailMessage;
use App\Form\EmailMessageType;
use App\Repository\EmailMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use app\Service\CheckerValidator;//
/**
 * @Route("/email/message")
 */
class EmailMessageController extends AbstractController
{
    /**
     * @Route("/", name="email_message_index", methods={"GET"})
     */
    public function index(Request $request, EmailMessageRepository $emailMessageRepository, PaginatorInterface $paginator): Response
    {
    
      
	$em = $this->getDoctrine()->getManager();
            $emailMessages = array_reverse($em->getRepository('App:EmailMessage')->findAll()); 
    $emailMessageRepository1 = $paginator->paginate(
            // Doctrine Query, not results
            $emailMessages,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );
        
        return $this->render('email_message/index.html.twig', [
            'email_messages' => $emailMessageRepository1,
        ]);
    }

    /**
     * @Route("/new", name="email_message_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $emailMessage = new EmailMessage();
        $form = $this->createForm(EmailMessageType::class, $emailMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emailMessage);
            $entityManager->flush();

            return $this->redirectToRoute('email_message_index');
        }

        return $this->render('email_message/new.html.twig', [
            'email_message' => $emailMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="email_message_show", methods={"GET"})
     */
    public function show(EmailMessage $emailMessage): Response
    {
        return $this->render('email_message/show.html.twig', [
            'email_message' => $emailMessage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="email_message_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EmailMessage $emailMessage): Response
    {
        $form = $this->createForm(EmailMessageType::class, $emailMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('email_message_index');
        }

        return $this->render('email_message/edit.html.twig', [
            'email_message' => $emailMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="email_message_delete", methods={"POST"})
     */
    public function delete(Request $request, EmailMessage $emailMessage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emailMessage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($emailMessage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('email_message_index');
    }
}
