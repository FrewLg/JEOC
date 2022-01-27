<?php

namespace App\Controller;

use App\Entity\CallForProposal;
use App\Entity\EditorialDecision;
use App\Entity\ReviewAssignment;
use App\Form\ReviewAssignmentType;
use App\Repository\ReviewAssignmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Review;
use App\Entity\GuidelineForReviewer;
use App\Form\GuidelineForReviewerType;
use App\Repository\GuidelineForReviewerRepository;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use App\Form\ReviewType;
use Symfony\Component\Form\Extension\Core\Type\DateType; 
use Symfony\Component\Form\Extension\Core\Type\CoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Submission; 
use App\Repository\SubmissionRepository;
use App\Repository\InstitutionalReviewersBoardRepository;
use App\Repository\ReviewRepository;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Entity\InstitutionalReviewersBoard;
use App\Helper\ReviewHelper;
use App\Repository\EvaluationFormRepository;
use App\Utils\Constants;
use DateTime;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Lexik\Bundle\TranslationBundle\Util\Csrf\CsrfCheckerTrait;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
// use Lexik\Bundle\TranslationBundle\Util\Csrf\CsrfCheckerTrait;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Csrf\CsrfToken;

/**
 * @Route("/irb-review")
 */
class IRBReviewController extends AbstractController
{
    use CsrfCheckerTrait;
  

    /**
     * @Route("/myassigned", name="myassigned", methods={"GET"})
     */
    public function myassigned(Request $request, PaginatorInterface $paginator): Response {
        
        $entityManager = $this->getDoctrine()->getManager();
        $me = $this->getUser()->getId();
        $this_is_me = $this->getUser();
        $myassigned = $entityManager->getRepository(ReviewAssignment::class)->findBy(['reviewer' => $this_is_me, 'closed' => NULL , 'Declined' => NULL ],["id"=>"DESC"]);
        ////// if no throw exception
        $myassigneds = $paginator->paginate(
            // Doctrine Query, not results
            $myassigned,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );
#################################################

$all = $entityManager->getRepository(ReviewAssignment::class)->findBy(['reviewer' => $this_is_me],["id"=>"DESC"]);
// $closedones = array_reverse($entityManager->getRepository(ReviewAssignment::class)->findBy(['reviewer' => $this_is_me, 'closed' => 1 , 'inactive_assignment' => NULL ]));
// ////// if no throw exception
// $closeds = $paginator->paginate(
//     // Doctrine Query, not results
//     $closedones,
//     // Define the page parameter
//     $request->query->getInt('page', 1),
//     // Items per page
//     10
// );


#################################################

$entityManager = $this->getDoctrine()->getManager();  
#######################

        #######################
        $query3 = $entityManager->createQuery(
        'SELECT    b.id , ass.invitation_sent_at as InvitationSentAt,     ass.Declined as Declined,  b.title , s.createdAt  , ass.duedate  as dueDate
        FROM App:Review s 
        JOIN s.submission b     
        JOIN s.reviewAssignment ass      
        WHERE   s.reviewed_by=:reviewer AND ass.inactive_assignment is NULL AND ass.closed=:closed
        -- HAVING     s.remark=:remarktwo

        ')  
        ->setParameter('closed', 1 )  
        ->setParameter('reviewer', $this_is_me   ) 
        ;

        $closeds = $query3->getResult();


#################################################

        return $this->render('submission/myassigned.html.twig', [
            'closeds' => $closeds,
            'all'=>$all,
            'myreviews' => $myassigneds,
        ]);
    }

    /**
     * @Route("/filter/{filter}/", name="submission_filter", methods={"GET"})
     */
    public function byfilter(Request $request, SubmissionRepository $submissionRepository, $filter, PaginatorInterface $paginator, FilterBuilderUpdaterInterface $query_builder_updater): Response {

        // $this->denyAccessUnlessGranted('assn_clg_cntr');
        $info = 'All';
        switch ($filter) {

        case 'al':
            $submissionRepository = $submissionRepository->getSubmissions();
            break;
        case 'cp':
            $submissionRepository = $submissionRepository->getSubmissions(['complete' => '1']);
            $info = 'Complete submission';
            break;
        case 'gr':
            $submissionRepository = $submissionRepository->getSubmissions(['submission_type' => 'grant']);
            $info = 'Grant';
            break;
        case 'cs':
            $submissionRepository = $submissionRepository->getSubmissions(['submission_type' => Constants::RESEARCH_TYPE_COMMUNITY_SERVICE]);
            $info = 'Community service';
            break;
        case 'mg':
         
            $submissionRepository = $submissionRepository->getSubmissions(['submission_type' => Constants::RESEARCH_TYPE_MEGA]);
            $info = 'Technology transfer';
            break;
        case 'tt':
            $submissionRepository = $submissionRepository->getSubmissions(['submission_type' =>Constants::RESEARCH_TYPE_TECHNOLOGY_TRANSFER]);
            $info = 'Technology transfer';
            break;
        case 'ps':
            $submissionRepository = $submissionRepository->getSubmissions(['published' => '1']);
            $info = 'Published';
            break;

        case 'rv':
            $submissionRepository = $submissionRepository->getSubmissions(['submission_type' => 'grant']);
            $info = 'Review assigned';
            break;
        case 'ic':
            $submissionRepository = $submissionRepository->getSubmissions(['complete' => '0']);
            $info = 'Incomplete ';
            break;
        default:
            return $this->redirectToRoute('submission_index');
     }

        // Paginate the results of the query
        $Allsubmissions = $paginator->paginate(
            // Doctrine Query, not results
            $submissionRepository,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );
        return $this->render('submission/index.html.twig', [
            'info' => $info,
            'submissions' => $Allsubmissions,
        ]);
    }


    /**
     * @Route("/{id}/assigned", name="his_assignment", methods={"GET"})
     */
    public function allassigned(Request $request, User $user, PaginatorInterface $paginator): Response {
        
        $entityManager = $this->getDoctrine()->getManager();
         
        $myassigned = $entityManager->getRepository(ReviewAssignment::class)->findBy(['reviewer' => $user  ],["id"=>"DESC"]);
        ////// if no throw exception
        $myassigneds = $paginator->paginate(
            // Doctrine Query, not results
            $myassigned,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );
#################################################

#################################################

        return $this->render('review_assignment/assigned.html.twig', [
            'user' => $user,
            'myreviews' => $myassigneds,
        ]);
    }


    /**
     * @Route("/{id}/revise", name="reviewsubmission", methods={"GET","POST"})
     */
    public function revise(Request $request, ReviewAssignment $reviewAssignment, EvaluationFormRepository $evaluationFormRepository): Response {
        ////Ultimate reviewers page
        
        $entityManager = $this->getDoctrine()->getManager();
        $me = $this->getUser()->getId();
        $submissionOfreviewer = $entityManager->getRepository(ReviewAssignment::class)->find($reviewAssignment);
        $metoo = $this->getUser();
        $me_as_a_reviewer = $submissionOfreviewer->getReviewer()->getId();
        $submissions = $submissionOfreviewer->getSubmission();
        $editorialDecisions = $entityManager->getRepository(EditorialDecision::class)->find($submissions);
        #dd($me_as_a_reviewer.$me);
        $iamareviewers = $entityManager->getRepository(ReviewAssignment::class)->findBy(['submission' => $submissions, 'reviewer' => $metoo]);

        // $myassigned =  $entityManager->getRepository(ReviewAssignment::class)->findBy($reviewAssignment);
        #######################
        if ($reviewAssignment->getClosed() == 1) {
            return $this->redirectToRoute('myassigned');

        }
        #######################
        foreach ($submissionOfreviewer as $muke) {
            $dd = $muke->getReviewer()->getId();
            echo $dd; #=  $muke->getReviewer()->getId();

            $lala = $dd . 'compare' . $me;
            /////////
            $me = $this->getUser()->getId();
            $thereviewerone = $reviewAssignment->getReviewer()->getId();
            if ($dd == $me) {

                return $this->redirectToRoute('myreviews');
                $this->addFlash(
                    'danger',
                    'Sorry you' . $dd . '//' . $me . ' never been assigned to this submision!'

                );

            }

            /////
        }
        $measareviewer = $this->getUser();
        $author = $submissions->getAuthor();
        //   $reviews=$entityManager->getRepository(Review::class)->findBy(['submission' => $submissions ] );

        if ($measareviewer == $author) {
            ////if you are the author then you can't review it///////
            $this->addFlash(
                'warining',
                'You can not see the submission you made in this page!'
            );
            return $this->redirectToRoute('myreviews');
        }

        if ($reviewAssignment->getReassigned()==1 ) {
            ////if you are the author then you can't review it///////
            $this->addFlash(
                'warining',
                'You have been re-assigned!'
            );
            return $this->redirectToRoute('rereviewsubmission', array('id' => $reviewAssignment->getId()));
        }



        $review = new Review();
        $review->setReviewAssignment($reviewAssignment);
        $review->setSubmission($reviewAssignment->getSubmission());
        $review->setReviewedBy($measareviewer);

        // $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $reviewfile = $form->get('attachment')->getData();
            if ($reviewfile == "") {
                $this->addFlash(
                    'danger',
                    'Review file  not uploaded!'
                );
            } else {
                $reviewfile = $form->get('attachment')->getData();
                $Areviewfile = md5(uniqid()) . '.' . $reviewfile->guessExtension();
                $reviewfile->move($this->getParameter('review_files'), $Areviewfile);
                $review->setAttachment($Areviewfile);
            }
            ##########
            $reviewfile2 = $form->get('evaluation_attachment')->getData();
            if ($reviewfile2 == "") {
                $this->addFlash(
                    'danger',
                    'Evaluation  file  not uploaded!'
                );
            } else {
                $reviewfile2 = $form->get('evaluation_attachment')->getData();
                $Areviewfile2 = md5(uniqid()) . '.' . $reviewfile2->guessExtension();
                $reviewfile2->move($this->getParameter('review_files'), $Areviewfile2);
                $review->setEvaluationAttachment($Areviewfile2);
            }
            ###############
            $review->setCreatedAt(new \DateTime());
            $review->setReviewedBy($this->getUser());
            $reviewAssignment->setClosed(1);

            $entityManager->persist($review);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'You have  completed a revision successfully!'
            );
            return $this->redirectToRoute('reviewsubmission', array('id' => $reviewAssignment->getId()));
        }

        $editorialDecision = new EditorialDecision();
        $editorialDecisionform = $this->createFormBuilder($editorialDecision)
      
            ->add('feedback', TextareaType::class, array(
                'attr' => array(
                    'placeholder' => 'Feedback  for the author',
                    'required' => true,
                    'class' => 'form-control',
                )))
            ->getForm();
        $editorialDecisionform->handleRequest($request);

 
        $reviews = $entityManager->getRepository(Review::class)->findBy(['submission' => $reviewAssignment->getSubmission(), 'reviewed_by' => $measareviewer]);

        return $this->render('submission/review_byreviewer.html.twig', [
            'review_assignment' => $reviewAssignment,
            'review_assignments' => $reviews,
            'submission' => $submissions,
            'editorialDecisions' => $editorialDecisions,
            'editorialDecisionform' => $editorialDecisionform->createView(),
            'form' => $form->createView(),
            'evaluationForms' => $evaluationFormRepository->findBy(['parent' => null]),
        ]);
    }




    /**
     * @Route("/{id}/rerevise", name="rereviewsubmission", methods={"GET","POST"})
     */
    public function rerevise(Request $request, ReviewAssignment $reviewAssignment, EvaluationFormRepository $evaluationFormRepository): Response {
        ////Ultimate reviewers page
        
        $entityManager = $this->getDoctrine()->getManager();
        $me = $this->getUser()->getId();
        // $id=  $review->getReviewAssignment()->getId();
        
 
        $submissionOfreviewer = $entityManager->getRepository(ReviewAssignment::class)->find($reviewAssignment);
        $metoo = $this->getUser();
        $me_as_a_reviewer = $submissionOfreviewer->getReviewer()->getId();
        $submissions = $submissionOfreviewer->getSubmission();
        $editorialDecisions = $entityManager->getRepository(EditorialDecision::class)->find($submissions);
        #dd($me_as_a_reviewer.$me);
        $iamareviewers = $entityManager->getRepository(ReviewAssignment::class)->findBy(['submission' => $submissions, 'reviewer' => $metoo]);

        // $myassigned =  $entityManager->getRepository(ReviewAssignment::class)->findBy($reviewAssignment);
        #######################
        if ($reviewAssignment->getClosed() == 1) {
            return $this->redirectToRoute('myassigned');

        }
        #######################
        foreach ($submissionOfreviewer as $muke) {
            $dd = $muke->getReviewer()->getId();
            echo $dd; #=  $muke->getReviewer()->getId();

            $lala = $dd . 'compare' . $me;
            /////////
            $me = $this->getUser()->getId();
            $thereviewerone = $reviewAssignment->getReviewer()->getId();
            if ($dd == $me) {

                return $this->redirectToRoute('myreviews');
                $this->addFlash(
                    'danger',
                    'Sorry you' . $dd . '//' . $me . ' never been assigned to this submision!'

                );

            }

            /////
        }
        $measareviewer = $this->getUser();
        $author = $submissions->getAuthor();
        //   $reviews=$entityManager->getRepository(Review::class)->findBy(['submission' => $submissions ] );

        if ($measareviewer == $author) {
            ////if you are the author then you can't review it///////
            $this->addFlash(
                'warining',
                'You can not see the submission you made in this page!'
            );
            return $this->redirectToRoute('myreviews');
        }
        // $review = new Review();
         
        $reviewid = $entityManager->getRepository(Review::class)->findOneBy(['reviewAssignment'=>$reviewAssignment->getId(), 'reviewed_by'=> $this->getUser()]);
        $review = $entityManager->getRepository(Review::class)->find($reviewid);

        $review->setReviewAssignment($reviewAssignment);
        $review->setSubmission($reviewAssignment->getSubmission());
        $review->setReviewedBy($measareviewer);

        // $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

 
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $reviewfile = $form->get('attachment')->getData();
            if ($reviewfile == "") {
                $this->addFlash(
                    'danger',
                    'Review  file  not uploaded!'
                );
            } else {
                $reviewfile = $form->get('attachment')->getData();
                $Areviewfile = md5(uniqid()) . '.' . $reviewfile->guessExtension();
                $reviewfile->move($this->getParameter('review_files'), $Areviewfile);
                $review->setAttachment($Areviewfile);
            }

              ##########
              $reviewfile2 = $form->get('evaluation_attachment')->getData();
              if ($reviewfile2 == "") {
                  $this->addFlash(
                      'danger',
                      'Evaluation  file  not uploaded!'
                  );
              } else {
                  $reviewfile2 = $form->get('evaluation_attachment')->getData();
                  $Areviewfile2 = md5(uniqid()) . '.' . $reviewfile2->guessExtension();
                  $reviewfile2->move($this->getParameter('review_files'), $Areviewfile2);
                  $review->setEvaluationAttachment($Areviewfile2);
              }
              ###############

            $review->setCreatedAt(new \DateTime());
            $review->setReviewedBy($this->getUser());
            $reviewAssignment->setClosed(1);

            $entityManager->persist($review);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'You have  completed a revision successfully!'
            );
            return $this->redirectToRoute('reviewsubmission', array('id' => $reviewAssignment->getId()));
        }

        $editorialDecision = new EditorialDecision();
        $editorialDecisionform = $this->createFormBuilder($editorialDecision)
      
            ->add('feedback', TextareaType::class, array(
                'attr' => array(
                    'placeholder' => 'Feedback  for the author',
                    'required' => true,
                    'class' => 'form-control',
                )))
            ->getForm();
        $editorialDecisionform->handleRequest($request);


       
        $reviews = $entityManager->getRepository(Review::class)->findBy(['submission' => $reviewAssignment->getSubmission(), 'reviewed_by' => $measareviewer]);

        return $this->render('submission/review_byreviewer.html.twig', [
            'review_assignment' => $reviewAssignment,
            'review_assignments' => $reviews,
            'submission' => $submissions,
            'editorialDecisions' => $editorialDecisions,
            'editorialDecisionform' => $editorialDecisionform->createView(),
            'form' => $form->createView(),
            'evaluationForms' => $evaluationFormRepository->findBy(['parent' => null]),
        ]);
    }
 
    /**
     * @Route("/{id}/granted", name="grant_winner", methods={"GET","POST"})
     */
    public function grantwinner(Submission $submission,  MailerInterface $mailer ): Response {
        ////Ultimate reviewers page
        $this->denyAccessUnlessGranted('ROLE_USER');
         
        $submission->setGranted(1);
        $this->getDoctrine()->getManager()->flush();
        

        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT u.email , s.id ,  u.username,   s.title 
                      , pi.first_name  , ui.alternative_email
                    FROM App:CoAuthor c
                    JOIN c.researcher u
                    JOIN u.userInfo ui
                    JOIN c.submission s
                    JOIN s.author p
                    JOIN p.userInfo pi 
                    WHERE   s.granted=:granted  and 
        c.submission = :submission'

        )
         ->setParameter('submission', $submission)  
        ->setParameter('granted', 1);
        $recepients = $query->getResult();
        // dd($recepients);

        $messages = $entityManager->getRepository('App:EmailMessage')->findOneBy(['email_key' => 'SUBMISSION_GRANTED_AWARDED_CO_PI']);
        $subject = $messages->getSubject();
        $body = $messages->getBody();

        foreach ($recepients as $row) {
            $theEmails[]             = $row['email'] . ' ';
            $theNames[] = $row['username'] . ' ';
            $theFirstNames[] = $row['username'] . ' ';
            $pi_name[] = $row['first_name'] . ' ';
            $titles[] = $row['title'] . ' ';
            $alternative_email[] = $row['alternative_email'] . ' ';
            $copi_id[] = $row['id'] . ' ';
            // dd($row[0]);

        }
        ////////////
        $length = count($recepients);
        for ($i = 0; $i < $length; $i++) {
            ///////////////
            $theFirstName = $theFirstNames[$i];
            if ($theFirstName == '') {
                $theFirstName = $theNames[$i];
                // dd($theFirstName);
            }
            if ($alternative_email[$i] == '') {
                $alternative_email[$i] = $theEmails[$i];
            }
            $pi_name = $theEmails[$i];
            $theEmail = $theEmails[$i];
            // $titles = $titles[$i];
             
            $invitation_url = 'submission/my-membership-details/' . $copi_id[$i];
            $email = (new TemplatedEmail())
                ->from(new Address('research@ju.edu.et', $this->getParameter('app_name')))
                ->to(new Address($theEmails[$i], $theFirstNames[$i]))
                // ->cc(new Address($alternative_email[$i], $theFirstNames[$i]))
                ->subject($subject)
                ->htmlTemplate('emails/granted-award-notice.html.twig')
                ->context([
                    'subject' => $subject,
                    'body' => $body,
                    'title' => $titles[$i],
                    'pi' => $submission->getAuthor()->getUserInfo(),
                    'submission_url' => $invitation_url,
                    'college' => $submission->getCallForProposal()->getCollege()->getPrincipalContact(),
                    'name' => $theFirstName,
                    'Authoremail' => $theEmail,
                ]);
            $mailer->send($email);
        }
        ########### For PI##############
        $applicantmessages = $entityManager->getRepository('App:EmailMessage')->findOneBy(['email_key' => 'SUBMISSION_GRANTED_AWARDED_PI']);
        $applicantsubject = $applicantmessages->getSubject();
        $applicantbody = $applicantmessages->getBody(); 
        $submission_url = 'submission/' . $submission->getId() . '/status';
        $applicant = $submission->getAuthor()->getEmail();
        $applicantname = $submission->getAuthor()->getUserInfo()->getFirstName();
        $emailtwo = (new TemplatedEmail())
            ->from(new Address('research@ju.edu.et', $this->getParameter('app_name')))
            ->to($applicant)
            ->subject($applicantsubject)
            ->htmlTemplate('emails/granted-award-notice.html.twig')
            ->context([
                'subject' => $applicantsubject,
                'body' => $applicantbody,
                'title' => $submission->getTitle(),
                'submission_url' => $submission_url,
                'college' => $submission->getCallForProposal()->getCollege()->getPrincipalContact(),

                'name' => $applicantname,
                'Authoremail' => $applicant
            ]);

        $mailer->send($emailtwo);
        ##########
// dd();
$this->addFlash( 
    'success',
    'You announced this submission as a winner successfully!'
); 
        return $this->redirectToRoute('submission_show', array('id' => $submission->getId()));

    }


      
  /**
     * @Route("/{id}/decline/", name="decline_invitation", methods={"GET","POST"})
     */
    public function declineinvitation(Request $request, ReviewAssignment $reviewAssignment): Response
    {
        

	$entityManager = $this->getDoctrine()->getManager();
    $mew= $this->getUser()->getId();
	$deadline= $reviewAssignment->getDuedate();
	$today= new \DateTime();
	$message='';
 	if ($deadline<=$today){
 	$message="Overdue!";
#	echo $day;
	}
	////if he is not the one he has been assigned to this proposal then redirect the page to the list of the submission he hasd been assigned to
	$reviewAssignment->setDeclined(1);
	$this->getDoctrine()->getManager()->flush();
	$this->addFlash( 
            'danger',
            'You declined your review invitation. The process will not be undone!'
        ); 
	return $this->redirectToRoute('myreviews');
}
    /**
     * @Route("/{id}", name="unassign", methods={"DELETE", "GET","POST"})
     */
    public function unassign(Request $request, ReviewAssignment $reviewAssignment  ): Response
    {
        $this->denyAccessUnlessGranted('assn_clg_cntr');

        if ($this->isCsrfTokenValid('delete'.$reviewAssignment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->remove($reviewAssignment);
            $reviewAssignment->setInactiveAssignment(1);
              $this->addFlash(
            'success',
            'Reviewer unassigned!'
        ); 
            $entityManager->flush();
        }
            return $this->redirectToRoute('review_assignment_new', array('id'=>$reviewAssignment->getSubmission()->getId()));
 
    }


    /**
     * @Route("/{id}", name="reassign", methods={"DELETE", "GET","POST"})
     */
    public function reassign( ReviewAssignment $reviewAssignment  ): Response
    {
        $this->denyAccessUnlessGranted('assn_clg_cntr');

             $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->remove($reviewAssignment);
            $reviewAssignment->setInactiveAssignment(NULL);
            $reviewAssignment->setClosed(NULL);
            $reviewAssignment->setReassigned(1);
            
              $this->addFlash(
            'success',
            'Reviewer allowed to edit the review  successfully!'
        ); 
            $entityManager->flush();
        
            return $this->redirectToRoute('review_assignment_new', array('id'=>$reviewAssignment->getSubmission()->getId()));
 
    }


  

  /**
     * @Route("/{id}/accept/", name="accept_invitation", methods={"GET","POST"})
     */
    public function acceptinvitation(Request $request, ReviewAssignment $reviewAssignment): Response
    {
        

    $entityManager = $this->getDoctrine()->getManager();
    if($this->getUser() != $reviewAssignment->getReviewer()){
        
        $this->addFlash("danger", "Sorry you are not allowed for this service !" );
        return $this->redirectToRoute('myassigned');
    }
   
    if(  $reviewAssignment->getDeclined()==1){
       
        
        $this->addFlash("danger", "Sorry invitation has declined !" );

        return $this->redirectToRoute('myassigned');
    }
    
    if ($reviewAssignment->getIsAccepted()){
        return $this->redirectToRoute('reviewsubmission', array('id' => $reviewAssignment->getId()));
}
    if ($reviewAssignment->getIsRejected()){
        // echo"'dsada'";
        // dd();
        return $this->redirectToRoute('myassigned');
}

if ($reviewAssignment->getIsRejected()){
    // echo"'dsada'";
    // dd();
    return $this->redirectToRoute('rereviewsubmission' );
}


        $submission=$reviewAssignment->getSubmission();
                 $workunit=$reviewAssignment->getSubmission();
	 $guideline_for_reviewers = $entityManager->getRepository(GuidelineForReviewer::class)->findAll()[0];
	$Allsubmission = $entityManager->getRepository(Submission::class)->findBy(['id' => $submission ] );
	$deadline= $reviewAssignment->getDuedate();
	$today= new \DateTime();
	$message='';
 	if ($deadline<=$today){
        
        $this->addFlash("danger", "Sorry Invitation overdue !" );

        //  $this->addFlash('error',"!!");
        return $this->redirectToRoute('myassigned');
}
 
        if ($request->request->get('accept-invitation')) {
            $this->checkCsrf('accept-invitation');
            $reviewAssignment->setAcceptedAt(new DateTime());
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('reviewsubmission', array('id' =>$reviewAssignment->getId()));
        }
 
	return $this->render('review_assignment/accept_invitation.html.twig', [
	'review_assignment' => $reviewAssignment,
	'guideline' => $guideline_for_reviewers,
        ]);
    }  

    

}
 
 
