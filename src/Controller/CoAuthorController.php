<?php

namespace App\Controller;

use App\Entity\CoAuthor;
use App\Entity\Submission;
use App\Form\CoAuthorType;
use App\Repository\CoAuthorRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/collaborators")
 */
class CoAuthorController extends AbstractController {
    /**
     * @Route("/", name="co_author_index", methods={"GET"})
     */
    public function index(CoAuthorRepository $coAuthorRepository): Response {
        return $this->render('co_author/index.html.twig', [
            'co_authors' => $coAuthorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="co_author_new", methods={"GET","POST"})
     */
    public function new (Request $request): Response {
        $coAuthor = new CoAuthor();
        $form = $this->createForm(CoAuthorType::class, $coAuthor);
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();
        $contributors = $entityManager->getRepository(CoAuthor::class)->findBy(['submission' => $submission]);
        $tag1 = new CoAuthor();
        $tag1->setName('Frew');
        $submission->getCoAuthors()->add($tag1);
        $tag2 = new CoAuthor();
        $tag2->setName('DSe');
        $submission->getCoAuthors()->add($tag2);
        // end dummy code

        $form = $this->createForm(coAuthorType::class, $coAuthor);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($coAuthor);
            $entityManager->flush();

            return $this->redirectToRoute('co_author_index');
        }

        return $this->render('submission/researchmembers.html.twig', [
            'co_author' => $coAuthor,
            'co_authors' => $contributors,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="co_author_show", methods={"GET"})
     */
    public function show(CoAuthor $coAuthor): Response {
        return $this->render('co_author/show.html.twig', [
            'co_author' => $coAuthor,
        ]);
    }

    /**
     * @Route("/{id}/{sub}/confirm", name="accept_involvemet", methods={"GET","POST"})
     */
    public function edit(Request $request, CoAuthor $coAuthor, Submission $sub , MailerInterface $mailer): Response {

        
         
        ##########################
               $userdetails = $this->getUser()->getUserInfo();
               if($userdetails->getFirstName()=='' ||$userdetails->getMidleName()=='' || 
               $userdetails ->getLastName() =='' ||
                $userdetails-> getCollege() =='' ||
                 $userdetails-> getEducationLevel() =='' || $userdetails-> getAcademicRank()==''  )
                
               {
                
                
                $this->addFlash("danger", "Please complete your profile first before you confirm  your Co-Authorship invitation  !");
               
               return $this->redirectToRoute('researchworks');
               }
               ##########################

#######################
$em  = $this->getDoctrine()->getManager();
$lastdate = $em->getRepository('App:CallForProposal')->find($sub->getCallForProposal());

 $deadline = $lastdate->getDeadline();
  $today = new \DateTime('');
  if ($deadline <= $today) {

     $this->addFlash("danger", "Sorry! Call has expired!  Thank you!");
    return $this->redirectToRoute('myreviews');
 }

################################


        $coAuthor->setConfirmed(1);
        $entityManager = $this->getDoctrine()->getManager();
        $pi = $sub->getAuthor();
        $entityManager->getRepository(CoAuthor::class)->find($sub);
        $this->getDoctrine()->getManager()->flush();
        
        $this->addFlash("success", "You have accepted the membership invitation to this submission. Thank you  !");
        $messages = $entityManager->getRepository('App:EmailMessage')->findOneBy(['email_key' => 'INVOLVEMENT_ACCEPTED_SUCCESS']);
        $recepient =  $pi->getEmail(); 
        $name =  $pi->getUserInfo()->getSuffix() . " " . $pi ->getUserInfo()->getFirstName();
        $pi_email = $this->getUser()->getEmail();
        $submssionId = $sub->getId();
        $application_url = 'submission/' . $submssionId . '/status';
        $subject = $messages->getSubject();
         $body = $messages->getBody();
    
        try {
            $email = (new TemplatedEmail())
                ->from(new Address('research@ju.edu.et', $this->getParameter('app_name')))
                ->to($recepient)
                ->cc($recepient)
                ->subject($subject)
                ->htmlTemplate('emails/membership_accepted.html.twig')
                ->context([
                    'subject' => $subject,
                    'body' => $body,
                    'id' => $submssionId, 
                    'title' => $sub->getTitle(),
                    'confirmed_by' =>   $this->getUser()->getUserInfo()->getFirstName().' '.$this->getUser()->getUserInfo()->getLastName(),
                    'name' => $name,
                    'submission_url' => $application_url, 
                    'Authoremail' => $pi_email])
            ;
    
            $mailer->send($email);
    
        } catch (TransportExceptionInterface $e) {$flashbag = $this->get
            ('session')->getFlashBag();
            $this->addFlash("warning", "Sorry email could'nt be
                 sent!" . $e . "!");return $this->redirectToRoute('submission_status', array
                ('id' => $sub->getId()));
    
        }

        return $this->redirectToRoute('membership');

    }

    /**
     * @Route("/{id}", name="co_author_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CoAuthor $coAuthor): Response {
        if ($this->isCsrfTokenValid('delete' . $coAuthor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($coAuthor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('co_author_index');
    }
}
