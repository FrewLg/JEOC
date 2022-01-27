<?php

namespace App\Controller;

use App\Entity\UserFeedback;
use App\Form\UserFeedbackType;
use App\Repository\UserFeedbackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user-feedback')]
class UserFeedbackController extends AbstractController
{
    #[Route('/all', name: 'user_feedback_index', methods: ['GET'])]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $this->denyAccessUnlessGranted('assn_clg_cntr');
        $entityManager = $this->getDoctrine()->getManager(); 
        $userFeedbacks = $entityManager->getRepository('App:UserFeedback')->findAll(); 
        $data = $paginator->paginate(
            $userFeedbacks,
            $request->query->getInt('page', 1), 
            $request->query->getInt('limit', 10)
        );
         return $this->render('user_feedback/index.html.twig', [
            'user_feedbacks' => $data,
        ]);
    }

    #[Route('/', name: 'user_feedback_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");
        $userFeedback = new UserFeedback();
        $form = $this->createForm(UserFeedbackType::class, $userFeedback);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userFeedback->setSentAt(new \DateTime());
            $userFeedback->setUser($this->getUser());
            $entityManager->persist($userFeedback);
            $entityManager->flush();
            $this->addFlash('success', "Your feedback has been sent successfully!   ");
            return $this->redirectToRoute('homepage');
        }
        return $this->render('user_feedback/new.html.twig', [
            'user_feedback' => $userFeedback,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'user_feedback_show', methods: ['GET'])]
    public function show(UserFeedback $userFeedback): Response
    {
        return $this->render('user_feedback/show.html.twig', [
            'user_feedback' => $userFeedback,
        ]);
    } 

    #[Route('/{id}', name: 'user_feedback_delete', methods: ['POST'])]
    public function delete(Request $request, UserFeedback $userFeedback, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userFeedback->getId(), $request->request->get('_token'))) {
            $entityManager->remove($userFeedback);
            $entityManager->flush();
        } 
        return $this->redirectToRoute('user_feedback_index', [], Response::HTTP_SEE_OTHER);
    }
}
