<?php

namespace App\Controller;

use App\Entity\CallForTraining;
use App\Form\CallForTrainingType;
use App\Repository\CallForTrainingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/call-for-training')]
class CallForTrainingController extends AbstractController
{
    #[Route('/', name: 'call_for_training', methods: ['GET'])]
    public function index(Request $request, CallForTrainingRepository $callForTrainingRepository, PaginatorInterface $paginator): Response

    {

        $em = $this->getDoctrine()->getManager();
        $callForTraining = $callForTrainingRepository->findBy(array('approved' => 1), ["id" => "DESC"]);

        $info = 'All';

        $alltraining = $paginator->paginate(
            $callForTraining,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('call_for_training/for_participants.html.twig', [
            'call_for_trainings' => $alltraining,
        ]);
    }

    #[Route('/adm', name: 'call_for_training_index', methods: ['GET'])]
    public function foradmin(Request $request,  CallForTrainingRepository $callForTrainingRepository, PaginatorInterface $paginator): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();


        $callForTraining = array_reverse($em->getRepository(CallForTraining::class)->findAll());



        // Paginate the results of the query
        $alltraining = $paginator->paginate(
            // Doctrine Query, not results
            $callForTraining,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );

        return $this->render('call_for_training/index.html.twig', [
            'call_for_trainings' => $alltraining,
        ]);
    }

    #[Route('/new', name: 'call_for_training_new', methods: ['GET', 'POST'])]
    public function new(Request $request,    EntityManagerInterface $entityManager): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $callForTraining = new CallForTraining();
        $form = $this->createForm(CallForTrainingType::class, $callForTraining);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $callForTraining->setCreatedAt(new \Datetime());
            $callForTraining->setCollege($this->getUser()->getUserInfo()->getCollege());
            $file3 = $form->get('document_attachment')->getData();
            if ($file3 == "") {
            } else {
                $file3 = $form->get('document_attachment')->getData();
                $fileName3 = md5(uniqid()) . '.' . $file3->guessExtension();
                $file3->move($this->getParameter('review_files'), $fileName3);
                $callForTraining->setDocumentAttachment($fileName3);
            }

            $entityManager->persist($callForTraining);
            $entityManager->flush();


            $this->addFlash("success", "Training has been created successfully !");


            return $this->redirectToRoute('call_for_training_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('call_for_training/new.html.twig', [
            'call_for_training' => $callForTraining,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'call_for_training_show', methods: ['GET'])]
    public function show(CallForTraining $callForTraining): Response
    {
        

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $ifexists = $em->getRepository('App:TrainingParticipant')->findBy(['participant' => $user, 'training' => $callForTraining]);



        return $this->render('call_for_training/show.html.twig', [
            'call_for_training' => $callForTraining,
            'ifexists' => $ifexists,
        ]);
    }


    #[Route('/{id}/adm', name: 'call_for_training_show_adm', methods: ['GET'])]
    public function admshow(CallForTraining $callForTraining): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('call_for_training/admshow.html.twig', [
            'call_for_training' => $callForTraining,
        ]);
    }
    #[Route('/{id}/edit', name: 'call_for_training_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,  CallForTraining $callForTraining, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(CallForTrainingType::class, $callForTraining);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $callForTraining->setCollege($this->getUser()->getUserInfo()->getCollege());
            $file3 = $form->get('document_attachment')->getData();
            if ($file3 == "") {
            } else {
                $file3 = $form->get('document_attachment')->getData();
                $fileName3 = md5(uniqid()) . '.' . $file3->guessExtension();
                $file3->move($this->getParameter('review_files'), $fileName3);
                $callForTraining->setDocumentAttachment($fileName3);
            }


            $entityManager->flush();

            return $this->redirectToRoute('call_for_training_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('call_for_training/edit.html.twig', [
            'call_for_training' => $callForTraining,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'call_for_training_delete', methods: ['POST'])]
    public function delete(Request $request, CallForTraining $callForTraining, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $callForTraining->getId(), $request->request->get('_token'))) {
            $entityManager->remove($callForTraining);
            $entityManager->flush();
        }

        return $this->redirectToRoute('call_for_training_index', [], Response::HTTP_SEE_OTHER);
    }
}
