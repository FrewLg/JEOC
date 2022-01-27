<?php

namespace App\Controller;

use App\Entity\TrainingParticipant; 
use App\Entity\CallForTraining;
use App\Form\TrainingParticipantType;
use App\Repository\TrainingParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Knp\Component\Pager\PaginatorInterface;


use Dompdf\Dompdf;
use Dompdf\Options;
#[Route('/apply-training')]
class TrainingParticipantController extends AbstractController
{
    #[Route('/{id}/', name: 'training_participant_index', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator, CallForTraining $callForTraining ): Response
    {
        $em = $this->getDoctrine()->getManager();

        $allcallForTraining = $em->getRepository('App:TrainingParticipant')->findBy(['training'=>$callForTraining]);

        $paginatedcallForTraining = $paginator->paginate(
            // Doctrine Query, not results
            $allcallForTraining,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );

        return $this->render('training_participant/index.html.twig', [
            'training_participants' => $paginatedcallForTraining  ,
            'callForTraining'=>$callForTraining,
        ]);
    }

    #[Route('/apply/{id}/', name: 'participate', methods: ['GET', 'POST'])]
    public function new(Request $request , CallForTraining $callForTraining, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $trainingParticipant = new TrainingParticipant();
      
        $userdetails = $this->getUser()->getUserInfo(); 
        $user = $this->getUser();  

        $$callForTraining = $entityManager->getRepository('App:CallForTraining')->find($callForTraining);
        if (  $userdetails->getFirstName() == '' || $userdetails->getMidleName() == '' ||
            $userdetails->getLastName() == '' ||
            $userdetails->getCollege() == ''  
             ) {
            
            $this->addFlash("danger", "Please complete your profile first before you  register for participation  !");

            return $this->redirectToRoute('myprofile');
        }

        $ifexists = $entityManager->getRepository('App:TrainingParticipant')->findBy(['participant'=>$user, 'training'=>$callForTraining] );

        if($ifexists){

            
            $this->addFlash("warning", "You have already been registered! Thank you");
            return $this->redirectToRoute('homepage');

        }

        $p_i_college = $this->getUser()->getUserInfo()->getCollege();

        if (!$p_i_college == $callForTraining->getCollege()) {
            
            $this->addFlash("danger", "You are not allowed to apply from" . $p_i_college . " !");

            return $this->redirectToRoute('researchworks');
        }
 
        
            $trainingParticipant->setParticipant($user);
        $trainingParticipant->setTraining($callForTraining); 
        $trainingParticipant->setAppliedAt(new \Datetime()); 
        $entityManager->persist($trainingParticipant);
        $entityManager->flush(); 
            
        
            $this->addFlash("success", "You have been successfully registered for training. Thank You!");
 
            $applicantmessages = $entityManager->getRepository('App:EmailMessage')->findOneBy(['email_key' => 'SUCCESSFUL_TRAINING_PARTICIPATION']);
                $applicantsubject = $applicantmessages->getSubject();
                $applicantbody = $applicantmessages->getBody();

                $submission_url = 'submission/' . $trainingParticipant->getId() . '/status';
                $applicant = $trainingParticipant->getParticipant()->getEmail();
                $applicantname = $trainingParticipant->getParticipant()->getUserInfo()->getFirstName();
                $emailtwo = (new TemplatedEmail())
                    ->from(new Address('research@ju.edu.et', $this->getParameter('app_name')))
                    ->to($applicant)
                    ->subject($applicantsubject)
                    ->htmlTemplate('emails/general.html.twig')
                    ->context([
                        'subject' => $applicantsubject,
                        'body' => $applicantbody,
                        'title' => $callForTraining->getName(),
                        'info' => 'Your request for '.$callForTraining->getName().' registration hit success',
                        'submission_url' => $submission_url,
                        'name' => $applicantname,
                        'Authoremail' => $applicant])
                ;

                $mailer->send($emailtwo);  

            return $this->redirectToRoute('call_for_training_show', array('id'=>$callForTraining->getId()));
   

         
    }

    /**
     * @Route("/{id}/cert", name="cert", methods={"GET"})
     */
    public function exportcertnow(Request $request, TrainingParticipant $uid) {

        // 

        $em = $this->getDoctrine()->getManager();

 
        $submission = $em->getRepository('App:TrainingParticipant')->findOneBy(['id' => $uid]);

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled', true);
        $pdfOptions->set('tempDir', '/tmp');
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->set_option("isPhpEnabled", true);

        $html = $this->renderView('training_participant/cert.html.twig', [
            'name' => $this->getUser(),
             'desc' => $submission->getTraining()->getDescription(),
             'type' => $submission->getTraining()->getTrainingType(),
             'date'=> $submission->getTraining()->getCreatedAt(),
             'about' => $submission->getTraining()->getName(),
             'training' => $submission->getTraining() ,
              
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        // $font = null;
        // $dompdf->getCanvas()->page_text(72, 18,  $font, 10, array(0, 0, 0));

        ob_end_clean();
        $filename = $submission->getParticipant();

        $dompdf->stream($filename . "- certificate.pdf", [
            "Attachment" => true,
        ]);
    }


//     public function disposeAction(Request $request )
//     {
//        $em = $this->getDoctrine()->getManager();  
//        $items = $em->getRepository('AppUABundle:Item')->findAll(); 
//        $users = $em->getRepository('AppUABundle:User')->findAll(); 
//        $item = new Item();  
//        $data = $request->request->all(); 
//        $selected_items = $data['ids'];  
//        foreach ($selected_items as $item_id) {
//          $item = $em->getRepository('AppUABundle:Item')->findBy($item_id); 
//          if ($request->request->has('is_on_hand_of') or $request->request->get('is_on_hand_of')) { 
//            $is_on_hand_of = $request->request->get('is_on_hand_of'); 
//            $is_on_hand_ofid = $em->getRepository('AppUABundle:User')->findOneById($is_on_hand_of); 
//            $item->setItemStatus($is_on_hand_ofid);
//            echo($item->getId()); 
//          }  
//          $em->persist($item);
//          $em->flush();
 //    } 
//        return $this->render('item/new.html.twig', array(
//            'items' => $items, 
//            'users' => $users, 
//        ));
   
//    } 


  
#[Route('/{id}/attendees', name: 'attended', methods: ['GET'])]
  
   public function attended(Request $request, CallForTraining $callForTraining )
   {
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

      $em = $this->getDoctrine()->getManager();     
      $defaultData= $em->getRepository('App:TrainingParticipant')->findBy(['training'=>$callForTraining]);  
               $form = $this->createFormBuilder($defaultData);
          $form = $form->getForm();
      if ($form->isSubmitted() && $form->isValid()) {     
          $i=0;
              foreach ($defaultData as $value) {
                   $data2= array('id' =>$request->request->get($defaultData[$i]['id']), 
                'discrecional' =>$request->request->get('D'.$defaultData[$i]['id'])); 
  
                  if (($request->request->get('D'.$defaultData[$i]['id'])== '0' and $defaultData[$i]['discrecional']=='0') or
                      ($request->request->get('D'.$defaultData[$i]['id'])== NULL and $defaultData[$i]['discrecional']=='1'))    
                  {
                   $em->getRepository('App:TrainingParticipant')->findBy($data2);
                   $value->setParticipated(1);
                  }
                  $i=$i+1; 
              }
          }
              ///////////////////////
      $em = $this->getDoctrine()->getManager();  
      
    //   $item = new TrainingParticipant(); 
    //   $data = $request->request->all(); 
    //   $selected_items = $data['ids'];  
    //   foreach ($selected_items as $item_id) {
    //     $item = $em->getRepository('App:TrainingParticipant')->find($item_id); 
    //     if ($request->request->has('is_on_hand_of') or $request->request->get('is_on_hand_of')) {
    //        $is_on_hand_of = $request->request->get('is_on_hand_of');
    //       $is_on_hand_ofid = $em->getRepository('App:TrainingParticipant')->findOneById($is_on_hand_of);
    //         $item->setIsOnHandOf($is_on_hand_ofid);
    //       echo($item->getId()); 
    //     } 
      
    //     $em->persist($item);
    //     $em->flush();
    //     return $this->redirectToRoute('all_items');
    //   // } 
//   } 
  return $this->render('training_participant/index.html.twig', array(
    'item' => $item,
          'form' => $form->createView(),
      ));
  
  } 
  

    #[Route('/{id}', name: 'training_participant_show', methods: ['GET'])]
    public function show(TrainingParticipant $trainingParticipant): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('training_participant/show.html.twig', [
            'training_participant' => $trainingParticipant,
        ]);
    }

    #[Route('/{id}/edit', name: 'training_participant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TrainingParticipant $trainingParticipant, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(TrainingParticipantType::class, $trainingParticipant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('training_participant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('training_participant/edit.html.twig', [
            'training_participant' => $trainingParticipant,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'training_participant_delete', methods: ['POST'])]
    public function delete(Request $request, TrainingParticipant $trainingParticipant, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$trainingParticipant->getId(), $request->request->get('_token'))) {
            $entityManager->remove($trainingParticipant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('training_participant_index', [], Response::HTTP_SEE_OTHER);
    }
}
