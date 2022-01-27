<?php

namespace App\Controller;

use App\Entity\ResearchReport;
use App\Form\ResearchReportType;
use App\Repository\ResearchReportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/research/report')]
class ResearchReportController extends AbstractController
{
    #[Route('/', name: 'research_report_index', methods: ['GET'])]
    public function index(ResearchReportRepository $researchReportRepository): Response
    {
        return $this->render('research_report/index.html.twig', [
            'research_reports' => $researchReportRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'research_report_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $researchReport = new ResearchReport();
        $form = $this->createForm(ResearchReportType::class, $researchReport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($researchReport);
            $entityManager->flush();

            return $this->redirectToRoute('research_report_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('research_report/new.html.twig', [
            'research_report' => $researchReport,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'research_report_show', methods: ['GET'])]
    public function show(ResearchReport $researchReport): Response
    {
        return $this->render('research_report/show.html.twig', [
            'research_report' => $researchReport,
        ]);
    }

    #[Route('/{id}/edit', name: 'research_report_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ResearchReport $researchReport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ResearchReportType::class, $researchReport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('research_report_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('research_report/edit.html.twig', [
            'research_report' => $researchReport,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'research_report_delete', methods: ['POST'])]
    public function delete(Request $request, ResearchReport $researchReport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$researchReport->getId(), $request->request->get('_token'))) {
            $entityManager->remove($researchReport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('research_report_index', [], Response::HTTP_SEE_OTHER);
    }
}
