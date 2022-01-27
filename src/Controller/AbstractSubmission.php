<?php

namespace App\Controller;

use App\Entity\Submission;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractSubmission extends AbstractController
{

    public function getResearchPhase(Submission $submission)
    {

        $phase = $submission->getCallForProposal()->getResearchReportPhase();
        if ($phase)
            return $phase;
    }
    public function isResearchReportTimeReached(Submission $submission)
    {

        $phase = $submission->getCallForProposal()->getResearchReportPhase();

        $research_report_count = sizeof($submission->getResearchReports());
        $phase = $this->getResearchPhase($submission);
        // dd($research_report_count,$phase);
        $is_elligble = $phase->getMaximumDuration() * ($research_report_count + 1);
        // dd(date_create($phase->getStartDate()->format('Y-m-d')),"+".$is_elligble." days");
       if(((new \DateTime('now'))>(date_modify(date_create($phase->getStartDate()->format('Y-m-d')),"+".$is_elligble." days"))))
       
            return true;
        return false;
    }
}
