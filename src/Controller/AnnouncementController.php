<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Form\AnnouncementType;
use App\Repository\AnnouncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Mime\NamedAddress;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

/**
 * @Route("/announce")
 */
class AnnouncementController extends AbstractController
{

    /**
     * @Route("/", name="announcement_index", methods={"GET"})
     */
    public function index(AnnouncementRepository $announcementRepository): Response
    {
        return $this->render('announcement/index.html.twig', [
            'announcements' => $announcementRepository->getPosted()->getResult(),
        ]);
    }


    /**
     * @Route("/new", name="announcement_new", methods={"GET","POST"})
     */
    public function new(Request $request, AnnouncementRepository $announcementRepository, MailerInterface $mailer,  PaginatorInterface $paginator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        
        $announcement = new Announcement();
        $form = $this->createForm(AnnouncementType::class, $announcement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $announcement->setPosetedAt(new \Datetime());
            $announcement->setPostedBy($user);
            $entityManager->persist($announcement);
            $entityManager->flush();
// <<<<<<< HEAD
	///////////// Let us email subscribed users to announcements
	$messages = $entityManager->getRepository('App:EmailMessage')->findOneBy(['email_key'=>'CALL_FOR_PROPOSAL_ANNOUNCEMENT']);
	$subject=$messages->getSubject();
	$body=$messages->getBody();
	$em = $this->getDoctrine()->getManager();
	$query = $entityManager->createQuery(
   	 'SELECT u.email , ui.first_name, u.username
	    FROM App:Subscription s
	    JOIN s.user u
	    JOIN u.userInfo ui
	    WHERE s.announcement = :subscribed')
    ->setParameter('subscribed', '1');
	$recepients = $query->getResult();
	 ///////////////Email for those who subscribed to website/////////
	$em = $this->getDoctrine()->getManager();
	$qb = $em->createQueryBuilder();
  	$messages = $em->getRepository('App:EmailMessage')->findOneBy(['email_key'=>'NEWS_NOTIFICATION']);
	$fl = $em->getRepository('App:User')->findAll();
 	$subject=$messages->getSubject();
 	$body=$messages->getBody();
 foreach ($recepients as $row ) {
  $theEmails[]=   $row['email'].' ';
  $theNames[]=   $row['username'].' ';
  $theFirstNames[]=   $row['first_name'].' ';
  }   
   $subject=$messages->getSubject();
            $body=$messages->getBody();
            foreach ($recepients as $row ) {
            $theEmails[]=   $row['email'].' ';
            $theNames[]=   $row['username'].' ';
            $theFirstNames[]=   $row['first_name'].' ';
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

            $this->addFlash("success", "Announcement posted!");
            //////////////////////////// end emailing ///////////////////////
            return $this->redirectToRoute('announcement_index');
        }
        $announcements = $announcementRepository->getData()->getResult();
        $paginatedannouncements = $paginator->paginate($announcements, $request->query->getInt('page', 1), 10);
        return $this->render('announcement/new.html.twig', [
            'announcements' => $paginatedannouncements,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="announcement_show")
     */
    public function show(Announcement $announcement,Request $request): Response
    {
        if($request->request->get('toogle_status')){
            $announcement->setIsPosted(!$announcement->getIsPosted());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success","Announcment Status changed!!");
            return $this->redirectToRoute('announcement_new');

        }
        return $this->render('announcement/show.html.twig', [
            'announcement' => $announcement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="announcement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Announcement $announcement): Response
    {
        $this->denyAccessUnlessGranted('ANNOUNCEMENT_EDIT', $announcement);
        $form = $this->createForm(AnnouncementType::class, $announcement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('announcement_index');
        }
        return $this->render('announcement/edit.html.twig', [
            'announcement' => $announcement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="announcement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Announcement $announcement): Response
    {
        $this->denyAccessUnlessGranted('ANNOUNCEMENT_EDIT', $announcement);


        if ($this->isCsrfTokenValid('delete' . $announcement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($announcement);
            $entityManager->flush();
            $this->addFlash("success", "Announcement deleted!");
        }

        return $this->redirectToRoute('announcement_new');
    }
}
