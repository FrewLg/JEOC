<?php

namespace App\Controller;

use App\Entity\BudgetRequest;
use App\Form\BudgetRequestType;
use App\Entity\Expense;
use App\Repository\BudgetRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
/**
 * @Route("/budget-request")
 */
class BudgetRequestController extends AbstractController
{
    /**
     * @Route("/", name="budget_request_index", methods={"GET"})
     */
    public function index(BudgetRequestRepository $budgetRequestRepository): Response
    {
        return $this->render('budget_request/index.html.twig', [
            'budget_requests' => $budgetRequestRepository->findAll(),
        ]);
    }

 /**
     * @Route("/email", name="send_mail", methods={"GET"})
     */
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('juservicesbackup@gmail.com')
            ->to('firewlegese74@gmail.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
   ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');
try {
    $mailer->send($email);
} catch (TransportExceptionInterface $e) {
    // some error prevented the email sending; display an
echo'de';
    // error message or try to resend the message
}

return new Response('Email sent');
        // ...
    }

    /**
     * @Route("/new", name="budget_request_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $budgetRequest = new BudgetRequest();
        $form = $this->createForm(BudgetRequestType::class, $budgetRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($budgetRequest);
            $entityManager->flush();

            return $this->redirectToRoute('budget_request_index');
        }

        return $this->render('budget_request/new.html.twig', [
            'budget_request' => $budgetRequest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="budget_request_show", methods={"GET"})
     */
    public function show(BudgetRequest $budgetRequest): Response
    {
        return $this->render('budget_request/show.html.twig', [
            'budget_request' => $budgetRequest,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="budget_request_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BudgetRequest $budgetRequest): Response
    {
        $form = $this->createForm(BudgetRequestType::class, $budgetRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('budget_request_index');
        }

        return $this->render('budget_request/edit.html.twig', [
            'budget_request' => $budgetRequest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="budget_request_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BudgetRequest $budgetRequest): Response
    {
        if ($this->isCsrfTokenValid('delete'.$budgetRequest->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($budgetRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('budget_request_index');
    }
}
