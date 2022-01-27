<?php

namespace App\Controller;

use App\Entity\ResearchReportPhase;
use App\Form\ResearchReportPhaseType;
use App\Repository\ResearchReportPhaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/research-report-phase')]
class ResearchReportPhaseController extends AbstractController
{
    #[Route('/', name: 'research_report_phase_index', methods: ['GET'])]
    public function index(ResearchReportPhaseRepository $researchReportPhaseRepository): Response
    {
        return $this->render('research_report_phase/index.html.twig', [
            'research_report_phases' => $researchReportPhaseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'research_report_phase_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $researchReportPhase = new ResearchReportPhase();
        $form = $this->createForm(ResearchReportPhaseType::class, $researchReportPhase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($researchReportPhase);
            $entityManager->flush();

            return $this->redirectToRoute('research_report_phase_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('research_report_phase/new.html.twig', [
            'research_report_phase' => $researchReportPhase,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'research_report_phase_show', methods: ['GET'])]
    public function show(ResearchReportPhase $researchReportPhase): Response
    {
        return $this->render('research_report_phase/show.html.twig', [
            'research_report_phase' => $researchReportPhase,
        ]);
    }

    #[Route('/{id}/edit', name: 'research_report_phase_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ResearchReportPhase $researchReportPhase, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ResearchReportPhaseType::class, $researchReportPhase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('research_report_phase_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('research_report_phase/edit.html.twig', [
            'research_report_phase' => $researchReportPhase,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'research_report_phase_delete', methods: ['POST'])]
    public function delete(Request $request, ResearchReportPhase $researchReportPhase, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$researchReportPhase->getId(), $request->request->get('_token'))) {
            $entityManager->remove($researchReportPhase);
            $entityManager->flush();
        }

        return $this->redirectToRoute('research_report_phase_index', [], Response::HTTP_SEE_OTHER);
    }
}
