<?php

namespace App\Helper;

use App\Entity\ResearchReport;
use App\Entity\ResearchReportSubmissionSetting;
use App\Entity\Submission;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class SubmissionHelper
{

    private $containerInterface;
    private $tokenInterface;
    private $em;
    private $urlGenerator;
    private $flashBagInterface;
    public function __construct(ContainerInterface $containerInterface, TokenStorageInterface $tokenInterface, EntityManagerInterface $em, FlashBagInterface $flashBagInterface, UrlGeneratorInterface $urlGenerator)
    {
        $this->containerInterface = $containerInterface;
        $this->tokenInterface = $tokenInterface;
        $this->flashBagInterface = $flashBagInterface;

        $this->urlGenerator = $urlGenerator;
        $this->em = $em;
    }
    public function createResearchReport($research_report_form, ResearchReport $researchReport, Submission $submission)
    {
        $user=$this->tokenInterface->getToken()->getUser();
        $uploadedFile = $research_report_form['file']->getData();
        $destination = $this->containerInterface->getParameter('kernel.project_dir') . '/public/research-report';
        $newFilename = $user->getId() . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
        $uploadedFile->move($destination, $newFilename);


        $researchReport->setFile($newFilename);
        $researchReport->setFileType($uploadedFile->getClientOriginalExtension());
        $researchReport->setSubmission($submission);
        $researchReport->setSubmittedBy($user);

        $this->em->persist($researchReport);
        $this->em->flush();
        $this->flashBagInterface->add("success", "Report submitted successfully!!");
        return new RedirectResponse($this->urlGenerator->generate("submission_status", ["id" => $submission->getId()]));
    }

    public function createSubmissionReportSchedule(Request $request, Submission $submission){
        foreach ($request->request->get('research_report_submission_setting') as $key => $value) {

            if ($key != "_token") {
                $submission_report_schedule = new ResearchReportSubmissionSetting();

                $submission_report_schedule->setSubmission($submission);
                $submission_report_schedule->setPhase(explode("_", $key)[1]);
                $submission_report_schedule->setSubmissionDate(new \DateTime($value));
                $this->em->persist($submission_report_schedule);
              
                $this->em->flush();
            }
        }
        $this->flashBagInterface->add("success", "Report submitted successfully!!");
        return new RedirectResponse($this->urlGenerator->generate("submission_status", ["id" => $submission->getId()]));
  
    }
}
