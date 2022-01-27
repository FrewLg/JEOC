<?php

namespace App\Controller;

use App\Entity\CallForProposal;
use App\Entity\CoAuthor;
use App\Entity\CollaboratingInstitution;
use App\Entity\EditorialDecision;
use App\Entity\Expense;
use App\Entity\PublishedSubmission;
use App\Entity\PublishedSubmissionAttachment;
use App\Entity\ResearchReport;
use App\Entity\ResearchReportSubmissionSetting;
use App\Entity\Review;
use App\Entity\ReviewAssignment;
use App\Entity\Submission;
use App\Entity\SubmissionAttachement;
use App\Entity\SubmissionBudget;
use App\Filter\Type\FilterFunctions;
use App\Filter\Type\SubmissionFilterType;
use App\Form\EditorialDecisionType;
use App\Form\ResearchReportSubmissionSettingType;
use App\Form\ResearchReportType;
use App\Form\ReviewType;
use App\Form\ReviewDecisionType;
use App\Form\SubmissionFilterType as FormSubmissionFilterType;
use App\Form\SubmissionType;
use App\Helper\SmsHelper;
use App\Helper\SubmissionHelper;
use App\Message\SendEmailMessage;
use App\Repository\CallForProposalRepository;
use App\Repository\EvaluationFormRepository;
use App\Repository\ReviewRepository;
use App\Repository\SubmissionRepository;
use App\Utils\Constants;
use Doctrine\ORM\Query\Expr;
use Dompdf\Dompdf;
use Dompdf\Options;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/submission")
 */

class SubmissionController extends AbstractController
{
    /**
     * @Route("/", name="submission_index", methods={"GET","POST"})
     */
    public function index(Request $request,   SubmissionRepository $submissionRepository,  PaginatorInterface $paginator,  FilterBuilderUpdaterInterface $query_builder_updater): Response
    {
        $this->denyAccessUnlessGranted('assn_clg_cntr');
        $em = $this->getDoctrine()->getManager();
        //  $submissionRepository = array_reverse($em->getRepository(Submission::class)->findAll());
        $formFilter = $this->createForm(SubmissionFilterType::class);
        $formFilter->handleRequest($request);
        $info = 'All';
        $submissionData = $submissionRepository->getSubmissions();
        if ($request->query->has($formFilter->getName())) {
            $filter = new FilterFunctions();
            $lexikFormFilter = $this->get('lexik_form_filter.query_builder_updater');
            $submissionData = $filter->filter($request, $formFilter, $em, $lexikFormFilter, 'App:User');
        }
        $sumissionFilterForm = $this->createForm(FormSubmissionFilterType::class);
        $sumissionFilterForm->handleRequest($request);
        if ($sumissionFilterForm->isSubmitted() && $sumissionFilterForm->isValid()) {

            $submissionData = $submissionRepository->getSubmissions($sumissionFilterForm->getData());

            //    dd($submissionData);

        }

        // Paginate the results of the query
        $Allsubmissions = $paginator->paginate(
            // Doctrine Query, not results
            $submissionData,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );
        return $this->render('submission/index.html.twig', [
            'formFilter' => $formFilter->createView(),
            'submissions' => $Allsubmissions,
            'info' => $info,
            'sumissionFilterForm' => $sumissionFilterForm->createView(),
        ]);
    }
    /**
     * @Route("/{id}/callresponses", name="callresponses", methods={"GET","POST"})
     */
    public function callresponses(Request $request, CallForProposal $call, PaginatorInterface $paginator): Response
    {
        $this->denyAccessUnlessGranted('assn_clg_cntr');
        $em = $this->getDoctrine()->getManager();
        //  $submissionRepository = array_reverse($em->getRepository(Submission::class)->findAll());
        $formFilter = $this->createForm(SubmissionFilterType::class);
        $formFilter->handleRequest($request);
        $info = $call->getSubject();
        $submissionRepository = $em->getRepository('App:Submission')->getSubmissions(['callForProposal' => $call]);

        // Paginate the results of the query
        $submissions = $paginator->paginate(

            $submissionRepository,
            $request->query->getInt('page', 1),

            10
        );
        return $this->render('submission/index.html.twig', [
            'submissions' => $submissions,
            'info' => $info,
        ]);
    }


    /**
     * @Route("/alert/", name="alert", methods={"GET","POST"})
     */
    public function alert(MailerInterface $mailer): Response
    {
        $this->denyAccessUnlessGranted('assn_clg_cntr');
        #####################################
        ///////////// Let us email  co-pis    to  remind
        $entityManager = $this->getDoctrine()->getManager();

        // $submission = $entityManager->getRepository('App:Submission')->findBy(['complete' => NULL]);
        $messages = $entityManager->getRepository('App:EmailMessage')->findOneBy(['email_key' => 'SUBMISSION_CO_PI_INVITATION']);
        $subject = $messages->getSubject();
        $body = $messages->getBody();
        $em = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT u.email , s.id ,  u.username,  s.complete, s.title 
                      , pi.first_name ,pi.gender, ui.alternative_email
                    FROM App:CoAuthor c
                    JOIN c.researcher u
                    JOIN u.userInfo ui
                    JOIN c.submission s
                    JOIN s.author p
                    JOIN p.userInfo pi 
                    WHERE  
 	     c.confirmed is NULL and s.complete=:completed'
        )

            ->setParameter('completed', 'completed');
        $recepients = $query->getResult();
        // dd($recepients);
        $em = $this->getDoctrine()->getManager();
        // $qb = $em->createQueryBuilder();
        $messages = $em->getRepository('App:EmailMessage')->findOneBy(['email_key' => 'SUBMISSION_CO_PI_REMINDER']);
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

            $body = 'Dear ' . $theFirstNames[$i] . ',  <br> 
                     ' . $pi_name . ' is waiting for you to respond 
                    to his recent proposal submisison entitled
            "' . $titles[$i] . ' ". Please respond to the invitaion using the invitation 
            link below before the deadline of the call.';
            $invitation_url = 'submission/my-membership-details/' . $copi_id[$i];
            $email = (new TemplatedEmail())
                ->from(new Address('research@ju.edu.et', $this->getParameter('app_name')))
                ->to(new Address($theEmails[$i], $theFirstNames[$i]))
                // ->cc(new Address($alternative_email[$i], $theFirstNames[$i]))
                ->subject($subject)
                ->htmlTemplate('emails/co-authorship-alert.html.twig')
                ->context([
                    'subject' => $subject,
                    'body' => $body,
                    'title' => $titles[$i],
                    'pi' => $pi_name,
                    'submission_url' => $invitation_url,
                    'name' => $theFirstName,
                    'Authoremail' => $theEmail,
                ]);
            $mailer->send($email);
        }
        ##########

        $this->addFlash("success", "Alert sent to Co-PI s successffully  !");

        return $this->redirectToRoute('submission_index');
    }
    /**
     * @Route("/wizard/{uidentifier}", name="submission_firststepold", methods={"GET","POST"})
     */
    public function metadata(Request $request, CallForProposal $callForProposal, UserController $test, MailerInterface $mailer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');


        #######################
        $em  = $this->getDoctrine()->getManager();

        $deadline = $callForProposal->getDeadline();
        $today = new \DateTime('');
        if ($deadline <= $today) {

            $this->addFlash("danger", "Sorry! Call has expired!  Thank you!");
            return $this->redirectToRoute('myreviews');
        }

        ################################
        ##########################
        $userdetails = $this->getUser()->getUserInfo();
        if ($userdetails == '') {
            $test->checkuser();
            return $this->redirectToRoute('myprofile');
        }
        // dd($userdetails);
        if (
            $userdetails->getFirstName() == '' || $userdetails->getMidleName() == '' ||
            $userdetails->getLastName() == '' ||
            $userdetails->getCollege() == '' ||
            $userdetails->getEducationLevel() == '' || $userdetails->getAcademicRank() == ''
        ) {

            $this->addFlash("danger", "Please complete your profile first before you submit the proposal  !");

            return $this->redirectToRoute('myprofile');
        }

        ##########################

        $p_i_college = $this->getUser()->getUserInfo()->getCollege();

        if (!$p_i_college == $callForProposal->getCollege()) {

            $this->addFlash("danger", "You are not allowed make a submission from" . $p_i_college . " !");

            return $this->redirectToRoute('researchworks');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $new = false;

        //dd($request->request);
        $submission = $entityManager->getRepository(Submission::class)->findOneBy(['author' => $this->getUser(), 'callForProposal' => $callForProposal]);
        if ($submission == null) {
            $new = true;
            $submission = new Submission();
        } else {
            if ($submission->getStep() == 10) {
                $this->addFlash('warning', "You have a  submission with this call. Edit your submission instead.");
                // return $this->redirectToRoute('myreviews');
            }
        }
        $submission->setCallForProposal($callForProposal);
        $submission->setUidentifier(md5(uniqid()));

        $form = $this->createForm(SubmissionType::class, $submission);
        $form->handleRequest($request);
        $submission->setStatus(1);
        if ($form->isSubmitted() && $form->isValid()) {
            $submission->setAuthor($this->getUser());

            if ($new) {
                $entityManager->persist($submission);
            }

            foreach ($submission->getSubmissionAttachements() as $key => $author) {

                // $file = $form->get('file')->getData();
                $files = $author->getFile('file');

                if ($files == NULL) {

                    $this->addFlash('danger', "Please upload a file with only valid word file format! Allowed file formats are  .doc , .docx , .odp ,
                ");

                    return $this->redirectToRoute('submission_firststepold', ["uidentifier" => $callForProposal->getUidentifier()]);
                }
            }

            if ($submission->getStep() == 10) {
                $submission->setSentAt(new \DateTime());

                $submission->setComplete("completed");
                $entityManager->flush();
                $this->addFlash('success', "submission complete");

                $invitation_url = 'submission/my-membership';
                #####################################
                ///////////// Let us email  co-pis    to  remind
                $messages = $entityManager->getRepository('App:EmailMessage')->findOneBy(['email_key' => 'SUBMISSION_CO_PI_INVITATION']);
                $subject = $messages->getSubject();
                $body = $messages->getBody();
                $em = $this->getDoctrine()->getManager();
                $query = $entityManager->createQuery(
                    'SELECT u.email ,  u.username
                    FROM App:CoAuthor s
                    JOIN s.researcher u
                    WHERE s.submission = :submission'
                )
                    ->setParameter('submission', $submission);
                $recepients = $query->getResult();
                $em = $this->getDoctrine()->getManager();
                $qb = $em->createQueryBuilder();
                $messages = $em->getRepository('App:EmailMessage')->findOneBy(['email_key' => 'SUBMISSION_CO_PI_INVITATION']);
                $subject = $messages->getSubject();
                $body = $messages->getBody();
                foreach ($recepients as $row) {
                    $theEmails[] = $row['email'] . ' ';
                    $theNames[] = $row['username'] . ' ';
                    $theFirstNames[] = $row['username'] . ' ';
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
                    $theEmail = $theEmails[$i];
                    $email = (new TemplatedEmail())
                        ->from(new Address('research@ju.edu.et', $this->getParameter('app_name')))
                        //    ->to($theEmails)
                        ->to(new Address($theEmails[$i], $theFirstNames[$i]))
                        ->bcc(new Address($theEmails[$i], $theFirstNames[$i]))
                        ->subject($subject)
                        ->htmlTemplate('emails/co-authorship-invitation.html.twig')
                        ->context([
                            'subject' => $subject,
                            'body' => $body,
                            'title' => $submission->getTitle(),
                            'submission_url' => $invitation_url,
                            'name' => $theFirstName,
                            'Authoremail' => $theEmail,
                        ]);
                    $mailer->send($email);
                }
                ##########
                $applicantmessages = $em->getRepository('App:EmailMessage')->findOneBy(['email_key' => 'EMAIL_KEY_SUBMISSION_ACKNOWLEDGEMENT']);
                $applicantsubject = $applicantmessages->getSubject();
                $applicantbody = $applicantmessages->getBody();

                $submission_url = 'submission/' . $submission->getId() . '/status';
                $applicant = $submission->getAuthor()->getEmail();
                $applicantname = $submission->getAuthor()->getUserInfo()->getFirstName();
                $emailtwo = (new TemplatedEmail())
                    ->from(new Address('research@ju.edu.et', $this->getParameter('app_name')))
                    ->to($applicant)
                    ->subject($applicantsubject)
                    ->htmlTemplate('emails/application_ack.html.twig')
                    ->context([
                        'subject' => $applicantsubject,
                        'body' => $applicantbody,
                        'title' => $submission->getTitle(),
                        'submission_url' => $submission_url,
                        'name' => $applicantname,
                        'Authoremail' => $applicant
                    ]);

                $mailer->send($emailtwo);

                // $sendEmail = new SendEmailMessage([$this->getUser()->getEmail()], Constants::EMAIL_KEY_SUBMISSION_ACKNOWLEDGEMENT, "emails/application_ack.html.twig", [
                // ]);
                // $this->dispatchMessage($sendEmail);
                // $emails = [];
                // foreach ($submission->getCoAuthors() as $key => $author) {
                //     $emails[] = $author->getEmail();
                // }
                // $sendEmail = new SendEmailMessage($emails, Constants::EMAIL_KEY_SUBMISSION_ACKNOWLEDGEMENT, "emails/application_ack.html.twig", [
                // ]);
                // $this->dispatchMessage($sendEmail);
                return $this->redirectToRoute('submission_status', array('id' => $submission->getId()));

                // return $this->redirectToRoute('myreviews');
            }
            $entityManager->flush();

            ##############################

            return $this->redirectToRoute('submission_firststepold', ["uidentifier" => $callForProposal->getUidentifier()]);
        }
        return $this->render('submission/metadata.html.twig', [
            'submissionform' => $form->createView(),
            'submission' => $submission,
            'call' => $callForProposal,
        ]);
    }
    /**
     * @Route("/{uid}/research-sumary", name="research_sumary", methods={"GET"})
     */
    public function exportnow(Request $request, $uid)
    {

        $this->denyAccessUnlessGranted('ROLE_USER');

        $em = $this->getDoctrine()->getManager();

        $submission = $em->getRepository('App:Submission')->findOneBy(['uidentifier' => $uid]);

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled', true);
        $data = file_get_contents('img/logo.png');
        $type = 'png';
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $pdfOptions->set('tempDir', '/home/ghost/Desktop/pdf-export/tmp');
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->set_option("isPhpEnabled", true);

        $html = $this->renderView('submission/summary.html.twig', [
            'user' => $this->getUser(),
            'base64' => $base64,
            'submission' => $submission,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $font = null;
        $dompdf->getCanvas()->page_text(72, 18, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0, 0, 0));

        ob_end_clean();
        $filename = $submission->getTitle();

        $dompdf->stream($filename . "file.pdf", [
            "Attachment" => false,
        ]);
    }

    // ob_end_clean();
    // $dompdf->stream();
    /**
     * @Route("/metadata/{id}/", name="submission_firststep_edit", methods={"GET","POST"})
     */
    public function metadataedit(Request $request, Submission $submission, CallForProposalRepository $callForProposalRepository, SmsHelper $smsHelper): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $entityManager = $this->getDoctrine()->getManager();
        $callForProposal = $submission->getCallForProposal();
        //////// =======check whather it is confirmed or not============
        $confirmed = $entityManager->getRepository(Submission::class)->find($submission);
        $is_submission_confirmed = $confirmed->getComplete();
        if ($is_submission_confirmed == '1') {
            $this->addFlash(
                'warning',
                'Confirmed submission will never be updated!'
            );
            return $this->redirectToRoute('submission_status', array('id' => $submission->getId()));
        }

        ////////////////////////////
        $therequest = $entityManager->getRepository(CallForProposal::class)->find($submission->getCallForProposal());

        ################### Are you the one? #################################
        $em = $this->getDoctrine()->getManager();
        $thisUser = $this->getUser();
        $myapplications = $em->getRepository(Submission::class)->find($submission);
        $requesteduser = $myapplications->getAuthor();
        if ($requesteduser !== $thisUser) {

            $this->addFlash("danger", "Sorry you are not allowed for this service ! Thank you!");
            return $this->redirectToRoute('myreviews');
        }
        ################### Are you the one? #################################

        $guidelines = $therequest->getGuidelines();
        //////////////////#####################check the call  deadline########################////////////////
        $deadline = $therequest->getDeadline();
        $today = new \DateTime();
        $message = '';
        if ($deadline <= $today) {
            $message = "Overdue!";
            #    echo $day;
        }
        //////

        $entityManager = $this->getDoctrine()->getManager();
        $mew = $this->getUser()->getId();
        $user = $this->getUser();
        //////allow reviewer if he is only assigned to this submission
        // $form = $this->createFormBuilder($submission)

        $form = $this->createForm(SubmissionType::class, $submission);
        $form->handleRequest($request);
        $submission->setStatus(1);
        if ($form->isSubmitted() && $form->isValid()) {
            $submission->setAuthor($this->getUser());

            if ($submission->getStep() == 10) {
                $submission->setSentAt(new \DateTime());

                $submission->setUidentifier(md5(uniqid()));

                $submission->setComplete("completed");
                $entityManager->flush();
                $this->addFlash('success', "submission complete");

                $sendEmail = new SendEmailMessage([$this->getUser()->getEmail()], Constants::EMAIL_KEY_SUBMISSION_ACKNOWLEDGEMENT, "emails/application_ack.html.twig", []);
                $this->dispatchMessage($sendEmail);
                $emails = [];
                foreach ($submission->getCoAuthors() as $key => $author) {
                    $emails[] = $author->getEmail();
                }
                $sendEmail = new SendEmailMessage($emails, Constants::EMAIL_KEY_SUBMISSION_ACKNOWLEDGEMENT, "emails/application_ack.html.twig", []);
                $this->dispatchMessage($sendEmail);

                try {


                    $message = sprintf("Dear %s your submission is completed.   \nJimma University", $this->getUser()->getUserInfo()->getFirstName());
                    $smsHelper->sendSms("new submission ", $message, '["' . $this->getUser()->getUserInfo()->getPhoneNumber() . '"]');
                } catch (\Throwable $th) {
                    $this->addFlash("warning", "error on sending sms." . $th->getMessage());
                }


                return $this->redirectToRoute('myreviews');
            }
            $entityManager->flush();
            return $this->redirectToRoute('submission_firststepold', ["uidentifier" => $callForProposal->getUidentifier()]);
        }
        return $this->render('submission/metadata.html.twig', [
            'submissionform' => $form->createView(),
            'submission' => $submission,
            'call' => $callForProposal,
        ]);
    }
    /**
     * @Route("/{id}/status", name="submission_status", methods={"GET","POST"})
     */
    public function statusubmission(Request $request, Submission $submission,SubmissionHelper $submissionHelper): Response
    {
        ////Ultimate reviewers page
        $this->denyAccessUnlessGranted('ROLE_USER');
        $entityManager = $this->getDoctrine()->getManager();

        ################### Are you the one? #################################
        $em = $this->getDoctrine()->getManager();
        $thisUser = $this->getUser();
        $myapplications = $em->getRepository(Submission::class)->find($submission);
        $requesteduser = $myapplications->getAuthor();
        if ($requesteduser !== $thisUser) {

            $this->addFlash("danger", "Sorry you are not allowed for this service ! Thank you!");
            return $this->redirectToRoute('myreviews');
        }
        ################### Are you the one? #################################

        $editorialDecisions = $entityManager->getRepository(EditorialDecision::class)->findBy(['submission' => $submission]);
        #dd($me_as_a_reviewer.$me);
        $measareviewer = $this->getUser();
        $author = $submission->getAuthor();

        // $reviews=$entityManager->getRepository(Review::class)->findBy(['submission' => $submission ] );
        $review = new Review();

        if (!$measareviewer == $author) {
            ////if you are the author then you can't review it///////
            $this->addFlash(
                'warining',
                'You can not see the submission you made in this page!'
            );
            return $this->redirectToRoute('myreviews');
        }
        //////allow reviewer if he is only assigned to this submission
        $form = $this->createFormBuilder($review)
            ->add('comment')
            ->add('attachment', FileType::class, [
                'label' => 'Review document  file',
                'mapped' => false,
                'required' => false,
            ])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $file3 = $review->getAttachment();
            $com = $review->getComment();
            if ($file3 == "") {
                echo 'file not uploaded';
            } else {
                $file3 = $form->get('attachment')->getData();
                $fileName3 = md5(uniqid()) . '.' . $file3->guessExtension();
                $file3->move($this->getParameter('review_files'), $fileName3);
                $review->setAttachment($fileName3);
            }
            $review->setSubmission($submission);
            $review->setCreatedAt(new \DateTime());
            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('submission_status', array('id' => $submission->getId()));
        }
        ////// if e submission has benn sent to the publication then allow researcher to upload final report of the research with respect to their attachment types
        $published = new PublishedSubmission();

        $entityManager = $this->getDoctrine()->getManager();
        #          $contributors=$entityManager->getRepository(CoAuthor::class)->findBy(['submission' => $submission ] );
        $publicationstatus = $entityManager->getRepository(PublishedSubmission::class)->findBy(['submission' => $submission]);
        $finalreportform = $this->createFormBuilder($published)
            ->add('attachement_type', EntityType::class, array(
                'placeholder' => '-- Select Component Type --',
                'class' => 'App\Entity\AttachementType',
                'attr' => array(
                    'empty' => '--select--- ',
                    'required' => false,
                    'class' => 'chosen-select form-control',
                ),
            ))
            ->add('published_date', DateType::class, array(
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ],
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => array(
                    'required' => true,
                    'class' => 'form-control',
                ),
            ))
            ->add('final_report', FileType::class, [
                'label' => 'Upload your terminal report file',
                'mapped' => false,
                'required' => true,
            ])
            ->getForm();
        $finalreportform->handleRequest($request);
        if ($finalreportform->isSubmitted() && $finalreportform->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $file3 = $published->getFinalReport();

            if ($file3 = '') {
                echo 'File not uploaded';
            } else {
                $file3 = $finalreportform->get('final_report')->getData();
                $fileName3 = md5(uniqid()) . '.' . $file3->guessExtension();
                $file3->move($this->getParameter('submission_files'), $fileName3);
                $published->setFinalReport($fileName3);
            }
            ////// check if there is publication has
            if ($entityManager->getRepository(PublishedSubmission::class)->findBy(['submission' => $submission, 'attachement_type' => $published->getAttachementType()])) {

                $this->addFlash("danger", "Sorry you have already uploaded '" . $fileName3 . "' file is the same attachment , please change  instead !");
                return $this->redirectToRoute('submission_status', array('id' => $submission->getId()));
            }
            $published->setSubmission($submission);
            $entityManager->persist($published);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Info saved successfully!'
            );
        }



        $submission_report_schedule_count = sizeof($submission->getResearchReportSubmissionSettings());

        $researchReportPhase = $submission->getCallForProposal()?->getResearchReportPhase();

    
        $submission_report_schedule_form =  $this->createForm(ResearchReportSubmissionSettingType::class, null, ["researchReportPhase" => $researchReportPhase]);
        $submission_report_schedule_form->handleRequest($request);

        if ($submission_report_schedule_form->isSubmitted()) {
            //create schedule
           return $submissionHelper->createSubmissionReportSchedule($request, $submission);
        }



        $researchReport = new ResearchReport();
        $research_report_form = $this->createForm(ResearchReportType::class, $researchReport)->handleRequest($request);

        if ($research_report_form->isSubmitted() && $research_report_form->isValid()) {

            //create research report
           return $submissionHelper->createResearchReport($research_report_form, $researchReport, $submission);
        }




        $attachements = $entityManager->getRepository(PublishedSubmissionAttachment::class)->findBy(['published_submission' => $publicationstatus]);
        $datasetused = new PublishedSubmissionAttachment();
        $entityManager = $this->getDoctrine()->getManager();
        $publicationstatus = $entityManager->getRepository(PublishedSubmission::class)->findBy(['submission' => $submission]);
        $Expenses = $entityManager->getRepository(SubmissionBudget::class)->findBy(['submission' => $submission]);
        $reviewsatge = $entityManager->getRepository(ReviewAssignment::class)->findBy(['submission' => $submission], ["id" => "DESC"]);
        $reviews = $entityManager->getRepository(Review::class)->findBy(['submission' => $submission, 'allow_to_view' => 1]);
        $contributors = $entityManager->getRepository(CoAuthor::class)->find($submission);
        return $this->render('submission/status.html.twig', [
            'co_authors' => $contributors,
            'expenses' => $Expenses,
            'comments' => $reviews,
            'datasets' => $attachements,
            'review_assignments' => $reviewsatge,
            'publicationstatus' => $publicationstatus,
            'submission' => $submission,
            'editorialDecisions' => $editorialDecisions,
            'finalreportform' => $finalreportform->createView(),
            'form' => $form->createView(),
            'research_report_form' => $research_report_form->createView(),
            'submission_report_schedule_form' => $submission_report_schedule_form->createView(),
            'submission_report_schedule_count' => $submission_report_schedule_count,
            'research_reports' => $submission->getResearchReports(),
        ]);
    }

    /**
     * @Route("/{id}/datasets", name="publication_datasets_used", methods={"GET","POST"})
     */
    public function datasets(Request $request, PublishedSubmission $publicationinfo): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $attachements = $entityManager->getRepository(PublishedSubmissionAttachment::class)->findBy(['published_submission' => $publicationstatus]);

        return $this->render('submission_includes/dataset_used.html.twig', [

            'datasets' => $attachements,

        ]);
    }
    /**
     * @Route("/{id}/dataset/new/", name="publication_datasets", methods={"GET","POST"})
     */
    public function datasetattachment(Request $request, PublishedSubmission $publicationinfo): Response
    {

        $datasetused = new PublishedSubmissionAttachment();

        $datasetusedform = $this->createFormBuilder($datasetused)
            ->add('attachment_type', EntityType::class, array(
                'placeholder' => '-- Select Attachment Type --',
                'class' => 'App\Entity\AttachementType',
                'attr' => array(
                    'empty' => 'Select attachment type-- ',
                    'required' => false,
                    'class' => 'chosen-select form-inline form-control col-md-6',
                ),
            ))
            ->add('description', TextareaType::class, array(

                'attr' => array(
                    'class' => 'form-inline  form-control col-md-6',
                ),
            ))

            ->add('dataset_label', TextType::class, [
                'attr' => array(
                    'required' => true,

                ),
                'attr' => array(
                    'class' => 'form-inline form-control col-md-6',
                ),

            ])
            ->add('attachment_file', FileType::class, [
                'label' => 'Upload  dataset file',
                'mapped' => false,
                'required' => true,
                'attr' => array(
                    'class' => 'form-control col-md-6',
                ),
            ])
            ->getForm();
        $datasetusedform->handleRequest($request);
        if ($datasetusedform->isSubmitted() && $datasetusedform->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $file3 = $datasetused->getAttachmentFile();

            if ($file3 = '') {
                echo 'File not uploaded';
            } else {
                $file3 = $datasetusedform->get('attachment_file')->getData();
                $fileName3 = md5(uniqid()) . '.' . $file3->guessExtension();
                $file3->move($this->getParameter('datasets'), $fileName3);
                $datasetused->setAttachmentFile($fileName3);
            }
            $datasetused->setPublishedSubmission($publicationinfo);

            $entityManager->persist($datasetused);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Info saved successfully!'
            );
            return $this->redirectToRoute('publication_datasets', array('id' => $publicationinfo->getId()));
        }
        $entityManager = $this->getDoctrine()->getManager();
        $datasets = $entityManager->getRepository(PublishedSubmissionAttachment::class)->findBy(['published_submission' => $publicationinfo]);
        return $this->render('published/dataset_form.html.twig', [
            'datasets' => $datasets,

            'datasetusedform' => $datasetusedform->createView(),

        ]);
    }

    /**
     * @Route("/attachment/{id}/deleteAttachment", name = "submission_attachment_delete", methods= {"DELETE"})
     */
    public function deleteAttachment(Request $request, SubmissionAttachement $submissionAttachement): Response
    {
        $callForProposal = $submissionAttachement->getSubmission()->getCallForProposal();
        if ($this->isCsrfTokenValid('delete' . $submissionAttachement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($submissionAttachement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('submission_firststepold', ["id" => $callForProposal->getId()]);
    }



    /**
     * @Route("/{id}/details", name="submission_show",  methods={"GET","POST"})
     */
    public function directorshow(Request $request,  Submission $submission, ReviewRepository $reviewRepository, MailerInterface $mailer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        ################### Are you the one? #################################
        $thisUser = $this->getUser();
        $requesteduser = $submission->getAuthor();
        if ($requesteduser == $thisUser) {

            $this->addFlash("danger", "Sorry you are not allowed for this service ! Thank you!");
            return $this->redirectToRoute('myreviews');
        }

        #####################################

        # $review = $entityManager->getRepository(Review::class)->findBy(['submission' => $submission ] );
        $budger_requests = $entityManager->getRepository(Expense::class)->findBy(['submission' => $submission]);
        $contributors = $entityManager->getRepository(CoAuthor::class)->findBy(['submission' => $submission]);
        $CollaboratingInstitutions = $entityManager->getRepository(CollaboratingInstitution::class)->findBy(['submission' => $submission]);
        $Expenses = $entityManager->getRepository(SubmissionBudget::class)->findBy(['submission' => $submission]);
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb = $qb
            ->select('SUM(e.requestedexpense) as totalRequested, SUM(e.approvedexpense) as Totalapproved')
            ->from('App\Entity\Expense', 'e')
            ->where($qb->expr()->andX(
                $qb->expr()->eq('e.submission', ':status'),
            ))
            ->setParameter('status', $submission)
            ->getQuery();
        $Overall_budger_request = $qb->getOneOrNullResult();
        $reviewers =  $entityManager->getRepository(ReviewAssignment::class)->findBy(['submission' => $submission]);
        $reviews = $entityManager->getRepository(Review::class)->findBy(['submission' => $submission]);
        ################ Admin Revision######################### 

        $review = new Review();
        $review->setSubmission($submission);
        $review->setReviewedBy($this->getUser());

        //////allow reviewer if he is only assigned to this submission
        // $form = $this->createFormBuilder($review)
        $form = $this->createForm(ReviewDecisionType::class, $review);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $reviewfile = $form->get('attachment')->getData();
            if ($reviewfile == "") {
                $review->setAttachment('');
            } else {
                $reviewfile = $form->get('attachment')->getData();
                $Areviewfile = md5(uniqid()) . '.' . $reviewfile->guessExtension();
                $reviewfile->move($this->getParameter('review_files'), $Areviewfile);
                $review->setAttachment($Areviewfile);
            }
            $review->setCreatedAt(new \DateTime());
            $review->setReviewedBy($this->getUser());
            ######################
            $review->setFromDirector(1);
            $review->setAllowToView(1);
            ######################
            ########### Let us mail it ###########  
            if ($form->get('remark')->getData() == 4) {

                $applicantmessages = $em->getRepository('App:EmailMessage')->findOneBy(['email_key' => 'EMAIL_KEY_SUBMISSION_STATUS_ACCEPTED']);
            } elseif ($form->get('remark')->getData() == 1) {
                $applicantmessages = $em->getRepository('App:EmailMessage')->findOneBy(['email_key' => 'EMAIL_KEY_SUBMISSION_STATUS_DECLINED']);
            }

            $applicantsubject = $applicantmessages->getSubject();
            $applicantbody = $applicantmessages->getBody();
            $submission_url = 'submission/' . $submission->getId() . '/status';
            $applicant = $submission->getAuthor()->getEmail();
            $applicantcc = $submission->getAuthor()->getUserInfo()->getAlternativeEmail();
            $applicantname = $submission->getAuthor()->getUserInfo()->getFirstName();
            $emailtwo = (new TemplatedEmail())
                ->from(new Address('research@ju.edu.et', $this->getParameter('app_name')))
                //->cc(new Address($applicantcc, $applicantname))
                ->to($applicant)
                ->subject($applicantsubject)
                ->htmlTemplate('emails/application_ack.html.twig')
                ->context([
                    'subject' => $applicantsubject,
                    'body' => $applicantbody,
                    'title' => $submission->getTitle(),
                    'submission_url' => $submission_url,
                    'name' => $applicantname,
                    'Authoremail' => $applicant
                ]);

            $mailer->send($emailtwo);

            ########### End Let us mail it ###########

            $entityManager->persist($review);
            $entityManager->flush();

            $this->addFlash("success", "Decision sent successfully!");
            return $this->redirectToRoute('submission_show', array('id' => $submission->getId()));
        }




        ################ Admin Revision#########################
        return $this->render('submission/submission_details.html.twig', [
            'submission' => $submission,
            'Overall_budger_request' => $Overall_budger_request,
            'review_assignments' => $reviewers,
            'reviews' => $reviews, 
            'adminvevisionform' => $form->createView(),
            'co_authors' => $contributors,
            'collaborating_institutions' => $CollaboratingInstitutions,
            'expenses' => $Expenses,
           
        ]);
    }

    /**
     * @Route("/my-membership", name="membership", methods={"GET"})
     */
    public function mymembership(Request $request,  PaginatorInterface $paginator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $entityManager = $this->getDoctrine()->getManager();

        $myemail = $this->getUser();
        // $membership = $entityManager->getRepository(CoAuthor::class)->findBy(['email' => $this_is_me]);
        $myresearches = $entityManager->getRepository(CoAuthor::class)->findBy(['researcher' => $myemail], ["id" => "DESC"]);
        ////// if no throw exception
        $Allmyresearches = $paginator->paginate(
            $myresearches,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('submission/co-authorship.html.twig', [
            'collaborations' => $Allmyresearches,
        ]);
    }



    /**
     * @Route("/all-grant-winners/", name="allawarded", methods={"GET","POST"})
     */

    public function allawarded(Request $request,  PaginatorInterface $paginator): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        $allawarded = $entityManager->getRepository(Submission::class)->findBy(['granted' => 1]);
        $Allmyresearches = $paginator->paginate(
            $allawarded,
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('submission/index.html.twig', [
            'info' => 'All grant winners ',
            'submissions' => $Allmyresearches,
        ]);
    }
    /**
     * @Route("/grant-winners/{uidentifier}/", name="call_winners", methods={"GET"})
     */
    public function call_winners(Request $request, CallForProposal $callForProposal, PaginatorInterface $paginator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        $allawarded = $entityManager->getRepository(Submission::class)->findBy(['granted' => 1, 'call_for_proposal' => $callForProposal]);

        $Allmyresearches = $paginator->paginate(
            $allawarded,
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('submission/index.html.twig', [
            'submissions' => $Allmyresearches,
            'info' => 'Grant winners of' . $callForProposal->getSubject(),
        ]);
    }


    /**
     * @Route("/my-membership-details/{id}", name="membershipdetails" ,  methods={"GET","POST"})
     */
    public function mymembershipdetails(Submission $submission): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');
        $entityManager = $this->getDoctrine()->getManager();
        $myresearche = $entityManager->getRepository(Submission::class)->find($submission);

        $user = $this->getUser();
        $allcoauthors = $entityManager->getRepository(CoAuthor::class)->find($submission);
        $member = $entityManager->getRepository(CoAuthor::class)->findBy(['submission' => $submission, 'researcher' => $this->getUser()]);


        if (!$member) {
            $this->addFlash("danger", "Sorry the you are not allowed for this service!");
            return $this->redirectToRoute('membership');
        }


        $entityManager = $this->getDoctrine()->getManager();
        $publicationstatus = $entityManager->getRepository(PublishedSubmission::class)->findBy(['submission' => $submission]);
        $Expenses = $entityManager->getRepository(SubmissionBudget::class)->findBy(['submission' => $submission]);
        $reviewsatge = $entityManager->getRepository(ReviewAssignment::class)->findBy(['submission' => $submission], ["id" => "DESC"]);
        $reviews = $entityManager->getRepository(Review::class)->findBy(['submission' => $submission, 'allow_to_view' => 1]);
        $contributors = $entityManager->getRepository(CoAuthor::class)->find($submission);

        return $this->render('submission/co-authorship_detail.html.twig', [
            'co_authors' => $contributors,
            'expenses' => $Expenses,
            'comments' => $reviews,
            'review_assignments' => $reviewsatge,
            'publicationstatus' => $publicationstatus,
            'submission' => $submission,

        ]);
    }

    /**
     * @Route("/myresearches", name="myreviews", methods={"GET"})
     */
    public function myresearches(Request $request, PaginatorInterface $paginator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $entityManager = $this->getDoctrine()->getManager();
        $me = $this->getUser()->getId();
        $this_is_me = $this->getUser();
        $myresearches = $entityManager->getRepository(Submission::class)->findBy(['author' => $me], ["id" => "DESC"]);
        $Assignment_id = $entityManager->getRepository(ReviewAssignment::class)->findBy(['reviewer' => $this_is_me]);
        ////// if no throw exception
        $Allmyresearches = $paginator->paginate(
            // Doctrine Query, not results
            $myresearches,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );

        return $this->render('submission/my_submission_review.html.twig', [
            'submissions' => $Allmyresearches,
            'myreviews' => $Assignment_id,
        ]);
    }
    /**
     * @Route("/{id}", name="submission_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Submission $submission): Response
    {
        if ($this->isCsrfTokenValid('delete' . $submission->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($submission);
            $entityManager->flush();
        }

        return $this->redirectToRoute('myreviews');
    }
}
