<?php

namespace App\Services;

use App\Entity\Submission;
use App\Form\SubmissionType;
use App\Entity\CallForProposal; 

class CheckerValidator extends AbstractController
{
 public function checkauthor(Submission $submission)
    {
    ////Ultimate reviewers page
     
    $entityManager = $this->getDoctrine()->getManager();
    $me= $this->getUser()->getId(); 
    
    /////
     $em = $this->getDoctrine()->getManager();
        $thisUser= $this->getUser()->getId();  
        $myapplications = $em->getRepository(Submission::class)->find($submission );
$requesteduser=$myapplications->getAuthor()->getId(); 
if($requesteduser!==$thisUser){


                $this->addFlash("danger", "Sorry you are not allowed for this service ! thank you!" );
        return $this->redirectToRoute('myreviews'); 

}
}
}
