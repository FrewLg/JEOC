<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Entity\User;
use App\Form\SubscriptionType;
use App\Repository\SubscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/subscription")
 */
class SubscriptionController extends AbstractController
{
    /**
     * @Route("/", name="subscription_index", methods={"GET"})
     */
    public function index(SubscriptionRepository $subscriptionRepository): Response
    {
        return $this->render('subscription/index.html.twig', [
            'subscriptions' => $subscriptionRepository->findAll(),
        ]);
    }        
    
    /**
     * @Route("/setting", name="subscription_new", methods={"GET","POST"})
     */
    public function managesbubs(Request $request ): Response
    {
         
         $user = $this->getUser(); 
                  $userid = $this->getUser()->getId(); 
         $em = $this->getDoctrine()->getManager();
         $mysubscriptions = $em->getRepository(Subscription::class)->findOneBy(['user'=>$user->getId()]);
	   if (!$mysubscriptions==NULL){ 
             $subscription = $em->getRepository(Subscription::class)->find($mysubscriptions);
         }
          else{ 
       // $subscription = $em->getRepository(Subscription::class)->find($user);
              $subscription =  new Subscription();
         }
         
         $subscriptionForm = $this->createForm(SubscriptionType::class, $subscription);  
         $subscriptionForm->handleRequest($request);
         $me = $this->getUser(); 
          if ($subscriptionForm->isSubmitted() && $subscriptionForm->isValid()) {
             $newss=$subscriptionForm->get('news')->getData();
             $entityManager=$this->getDoctrine()->getManager();
            //$subscription->setNews(1);            
            $subscription->setUser($user);
                    //    $subscription->setCalls(1);
            $subscription->setEmail($user->getEmail());
            $entityManager->persist($subscription);
            $entityManager->flush();
            return $this->redirectToRoute('myprofile');
        }
        return $this->render('subscription/new.html.twig', [
            'subscription' => $subscription,
            'form' => $subscriptionForm->createView(),
        ]);
    }
    
         
    
    
    /**
     * @Route("/unsbscribe-for-all", name="unsbscribe", methods={"GET","POST"})
     */
    public function unsbscribe(Request $request): Response
    {
    
               
         $user = $this->getUser(); 
         $em = $this->getDoctrine()->getManager();
         $subscription = $em->getRepository(Subscription::class)->find($user);
	
	  if ($subscription==NULL){
         $subscription= new Subscription();
         }
         else{
             $subscription = $em->getRepository(Subscription::class)->find($user);
         }
         
         $subscriptionForm = $this->createForm(SubscriptionType::class, $subscription);  
         $subscriptionForm->handleRequest($request);
         $me = $this->getUser(); 
          if ($subscriptionForm->isSubmitted() && $subscriptionForm->isValid()) {
             $newss=$subscriptionForm->get('news')->getData(); 
             $entityManager=$this->getDoctrine()->getManager();
            $subscription->setNews(0);            
            $subscription->setCalls(0); 
            $subscription->setAnnouncement(0); 
            $subscription->setNewSubmission(0); 
            $subscription->setUser($me); 
            $entityManager->persist($subscription);
            $entityManager->flush();
            return $this->redirectToRoute('myprofile');
        }
        return $this->render('subscription/unsubscribe.html.twig', [
            'subscription' => $subscription,
            'form' => $subscriptionForm->createView(),
        ]);
 
}
}
