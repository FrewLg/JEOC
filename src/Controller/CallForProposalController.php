<?php

namespace App\Controller;

use App\Entity\CallForProposal;
use App\Entity\ResearchReportPhase;
use App\Form\CallForProposalType;
use App\Form\ResearchReportPhaseType;
use App\Form\ResearchType;
use App\Repository\CallForProposalRepository;
use App\Repository\SubmissionRepository;
use App\Utils\Constants;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/call-for-proposals")
 */
class CallForProposalController extends AbstractController
{
    /**
     * @Route("/list", name="all_calls", methods={"GET"})
     */
    public function adminlist(Request $request, CallForProposalRepository $callForProposalRepository, PaginatorInterface $paginator): Response
    {

        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $call_for_proposalRepository = $callForProposalRepository->getCalls(['college' => $this->getUser()->getUserInfo()->getCollege()]);
        $info = 'All';

        $Allsubmissions = $paginator->paginate(
            $call_for_proposalRepository,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('call_for_proposal/adminindex.html.twig', [
            //            'formFilter' => $formFilter->createView(),
            'call_for_proposals' => $Allsubmissions,

        ]);
    }


    /**
     * @Route("/", name="call_for_proposal_all", methods={"GET"})
     */
    public function allCalls(CallForProposalRepository $callForProposalRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        //$callForProposals = array_reverse($em->getRepository(CallForProposal::class)->findAll());
        $callForProposals = $callForProposalRepository->getCalls(array('approved' => 1));
        // Paginate the results of the query
        $AllcallForProposal = $paginator->paginate(
            // Doctrine Query, not results
            $callForProposals,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );

        return $this->render('call_for_proposal/index.html.twig', [
            'call_for_proposals' => $AllcallForProposal,
        ]);
    }

    /**
     * @Route("/new", name="call_for_proposal_new", methods={"GET","POST"})
     */
    public function new(Request $request, MailerInterface $mailer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $callForProposal = new CallForProposal();
        $form = $this->createFormBuilder($callForProposal)
            ->add('research_type', ResearchType::class)

            #->add('deadline')
            ->add('subject', CKEditorType::class, [
                'attr' => [
                    'placeholder' => 'Body of the call',
                    'class' => 'form-control  col col-md-12 col-sm-12 col-lg-9  ',
                    'required' => false,

                ]
            ])
            ->add('heading', CKEditorType::class, [
                'attr' => [
                    'placeholder' => 'Heading title of the call',
                    'class' => 'form-control col col-md-12 col-sm-12 col-lg-9  ',
                    'required' => false,

                ]
            ])
            ->add('guidelines', CKEditorType::class, [
                'attr' => [
                    'placeholder' => 'Guideline details',
                    'class' => 'form-control  col col-md-12 col-sm-12 col-lg-9  ',
                    'required' => false,

                ]
            ])
            ->add('deadline', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ))

            //               ->add('thematic_area', EntityType::class, array(
            //     'placeholder' => '-- Select Thematic area--',

            //     'class' => 'App\Entity\ThematicArea',
            //      'attr' => array(
            //          'empty' => 'Select disability detail ',
            //          'required' => true,
            // 'class' => 'form-control form-inline col col-md-12 col-sm-12 col-lg-9 ',

            //      )
            //  ))
            ->add('funding_source', TextType::class, [
                'attr' => ['class' => 'form-control col col-md-12 col-sm-12 col-lg-9 '],
            ])

            ->add('review_process_start', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ))
            ->add('review_process_end', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ))
            ->add('reviewers_decision_will_be_communicated_at', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',

            ))
            ->add('project_starts_on', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ))
            // ->add('number_of_co_pi')
            ->add('allow_non_academic_staff_as_pi')
            // ->add('allow_researcher_from_another_college')
            ->add('allow_pi_from_other_university')
            ->add('commitment_from_other_research')
            ->add('is_call_from_center')
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $callForProposal->setPostDate(new \Datetime());
            // $callForProposal->setWorkUnit(1);
            $heading = $callForProposal->getHeading();
            $guideline = $callForProposal->getGuidelines();
            $call_id = $callForProposal->getId();
            $the_id = $call_id . '-' . $heading;
            $identifier = md5(uniqid($the_id));
            $callForProposal->setUidentifier($identifier);
            if ($form->get('is_call_from_center')->getData() == 0) {

                // dd($this->getUser()->getUserInfo()->getCollege());
                $callForProposal->setCollege($this->getUser()->getUserInfo()->getCollege());
                // $this->getUser()->getUserInfo()->getCollege( );

                $Princiapal_contacts = $this->getUser()->getUserInfo()->getCollege()->getPrincipalContact();
            }

            $entityManager->persist($callForProposal);
            $entityManager->flush();
            ///////////////Email for those who subscribed to website/////////

            ///////////// Let us email subscribed users to announcements

            $em = $this->getDoctrine()->getManager();
            $query = $entityManager->createQuery(
                'SELECT u.email , u.first_name, u.username 
	    FROM App:Subscription s
	    JOIN s.user u
	    WHERE s.calls = :subscribed'
            )
                ->setParameter('subscribed', '1');
           

            $this->addFlash("success", "Call for proposal created suucessflly and will be approved later!");
            //////////////////////////// end emailing ///////////////////////

            // return $this->redirectToRoute('all_calls' );
            return $this->redirectToRoute('call__details', array('id' => $callForProposal->getid()));
        }

        return $this->render('call_for_proposal/new.html.twig', [
            'call_for_proposal' => $callForProposal,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/{id}/research_report_phase_show', name: 'call_research_report_phase', methods: ['GET', "POST"])]
    public function show(CallForProposal $call_for_proposal, EntityManagerInterface $entityManager, Request $request): Response
    {


        $researchReportPhase =   $call_for_proposal->getResearchReportPhase() ?:  new ResearchReportPhase();
        $form = $this->createForm(ResearchReportPhaseType::class, $researchReportPhase)->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $request_data = $request->request->get("research_report_phase");

            if (!isset($request_data['startDate'])) {
                $form->addError(new FormError("Start date not set"));
            } else if (!isset($request_data['endDate'])) {
                $form->addError(new FormError("End date not set"));
            } else {

                $researchReportPhase->setStartDate(new \DateTime($request_data['startDate']));
                $researchReportPhase->setEndDate(new \DateTime($request_data['endDate']));
                $researchReportPhase->setApplicationCall($call_for_proposal);
                $researchReportPhase->setCreatedBy($this->getUser());
                $entityManager->persist($researchReportPhase);
                $entityManager->flush();
                $this->addFlash("success", "Action done!!");


                return $this->redirectToRoute('call_research_report_phase', ["id" => $call_for_proposal->getId()], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('call_for_proposal/research_phase.html.twig', [
            'call_for_proposal' => $call_for_proposal,
            'research_report_phase' => $researchReportPhase,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/undo-approve", name="call_approve_undo", methods={"GET"})
     */
    public function undoapprove(CallForProposal $callForProposal): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $approver = $this->getUser();
        $callForProposal->setApproved(0);
        // $callForProposal->setApprovedBy($approver);
        // $callForProposal->setApprovedAt(new \Datetime());
        $this->getDoctrine()->getManager()->flush();
        // return $this->redirectToRoute('all_calls');
        return $this->redirectToRoute('all_calls');
    }



    /**
     * @Route("/{uidentifier}/result", name="call_approved_result", methods={"GET"})
     */
    public function result(CallForProposal $callForProposal, SubmissionRepository $submissionRepository): Response
    {

        $results = $submissionRepository->filterApproved($callForProposal);

        return $this->render('call_for_proposal/result.html.twig', [
            'results' => $results,
            'call_for_proposal' => $callForProposal
        ]);
    }
    /**
     * @Route("/{id}/approve", name="call__approve", methods={"GET"})
     */
    public function approve(CallForProposal $callForProposal): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $approver = $this->getUser();
        $callForProposal->setApproved(1);
        $callForProposal->setApprovedBy($approver);
        $callForProposal->setApprovedAt(new \Datetime());
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('all_calls');
    }


    /**
     * @Route("/{uidentifier}/sendbatch", name="calsendbatch_email", methods={"GET"})
     */
    public function sendbatch(CallForProposal $callForProposal, MailerInterface $mailer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();

        ///////////// Let us email subscribed users to announcements 
        $query = $entityManager->createQuery(
            'SELECT u.email , ui.first_name, u.username
	    FROM App:Review s
	    JOIN s.submission r
	    JOIN r.callForProposal c
	    JOIN r.author u 
	    JOIN u.userInfo ui
	    WHERE s.from_director = 1 and s.remark=4  and c.id=:callForProposal'
        )
            ->setParameter('callForProposal', $callForProposal);

        $recepients = $query->getResult();
        dd($recepients);
        ///////////////Email for those who subscribed to website/////////
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $messages = $em->getRepository('App:EmailMessage')->findOneBy(['email_key' => 'PRESENTATION_SCHEDULE_NOTIFICATION']);
        $fl = $em->getRepository('App:User')->findAll();
        $subject = $messages->getSubject();
        $body = $messages->getBody();
        foreach ($recepients as $row) {
            $theEmails[] =   $row['email'] . ' ';
            $theNames[] =   $row['username'] . ' ';
            $theFirstNames[] =   $row['first_name'] . ' ';
        }


        ////////////
        $length = count($recepients);
        for ($i = 0; $i < $length; $i++) {
            /////////////// 
            $theFirstName = $theFirstNames[$i];
            if ($theFirstName == '') {
                $theFirstName = $theNames[$i];
                dd($theFirstName);
            }
            $theEmail = $theEmails[$i];
            $email = (new TemplatedEmail())
                ->from(new Address('no-reply@ju.edu.et', 'Jimma University Research  Office'))
                //    ->to($theEmails)
                ->to(new Address($theEmails[$i], $theFirstNames[$i]))
                // ->bcc(new Address($theEmails[$i], $theFirstNames[$i]))
                ->subject($subject)
                ->htmlTemplate('emails/news.html.twig')
                ->context([
                    'subject' => $subject,
                    'body' => $body,
                    'name' => $theFirstName,
                    'Authoremail' => $theEmail,
                ]);
            $mailer->send($email);
        }

        $this->addFlash("success", "Email sent to short listed porposal PIs successfully!");
        //////////////////////////// end emailing ///////////////////////
        return $this->redirectToRoute('announcement_index');
    }

    /**
     * @Route("/{id}/show", name="call__details", methods={"GET"})
     */
    public function details(CallForProposal $callForProposal): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $number_of_applicants = $qb
            ->select('COUNT(e.id) as Proposals ')
            ->from('App\Entity\Submission', 'e')
            ->andWhere('e.callForProposal = :callForProposal')
            #->setParameter( 'status', '1' )
            ->setParameter('callForProposal', $callForProposal)
            ->groupBy('e.callForProposal')
            ->getQuery()->getResult();

        return $this->render('call_for_proposal/admin_details.html.twig', [
            'call_for_proposal' => $callForProposal,
            'number_of_applicants' => $number_of_applicants,
        ]);
    }
    /**
     * @Route("/{uidentifier}/details", name="call_for_proposal_show", methods={"GET"})
     */
    public function showdetails(CallForProposal $call_for_proposal): Response
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $number_of_applicants = $qb
            ->select('COUNT(e.id) as Proposals ')
            ->from('App\Entity\Submission', 'e')

            ->andWhere('e.callForProposal = :callForProposal')
            #->setParameter( 'status', '1' )
            ->setParameter('callForProposal', $call_for_proposal)
            ->groupBy('e.callForProposal')
            ->getQuery()->getResult();

        $viewscount = $call_for_proposal->getViews();
        $viewscount = $viewscount + 1;
        $call_for_proposal->setViews($viewscount);
        $this->getDoctrine()->getManager()->flush();

        return $this->render('call_for_proposal/show.html.twig', [
            'call_for_proposal' => $call_for_proposal,
            'number_of_applicants' => $number_of_applicants,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="call__edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CallForProposal $callForProposal): Response
    {
        //    $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(CallForProposalType::class, $callForProposal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('call_for_proposal_all');
        }

        return $this->render('call_for_proposal/edit.html.twig', [
            'call_for_proposal' => $callForProposal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="call_for_proposal_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CallForProposal $callForProposal): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $callForProposal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($callForProposal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('call_for_proposal_all');
    }
}
