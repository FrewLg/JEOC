<?php
// src/Controller/DefaultController.php
namespace App\Controller;
use App\Entity\Announcement;
//use App\Entity\CallForProposal;
use App\Form\AnnouncementType;
use App\Repository\AnnouncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\WorkUnit;
use App\Form\WorkUnitType;

use Knp\Component\Pager\PaginatorInterface;
use App\Repository\SiteSettingRepository;
use App\Entity\SiteSetting;
use App\Repository\WorkUnitRepository;
use App\Message\SmsNotification;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpFoundation\Request;
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request,AuthenticationUtils $authenticationUtils, PaginatorInterface $paginator): Response
    {
      
	$em = $this->getDoctrine()->getManager();
	$news = $em->getRepository(Announcement::class)->getPosted();
	$qb = $em->createQueryBuilder();
    	

   return $this->render('home/homepage.html.twig', [
            'announcements'=> $newss,
        ]);
    }
     
      /**
     * @Route("/contact", name="contact")
     */
    public function contact(SiteSettingRepository $siteSettingRepository): Response
    {
 
	$em = $this->getDoctrine()->getManager();
	$contactus = $em->getRepository(SiteSetting::class)->findBy(['name'=>'CBE']);
	//$contact_us=$contactus->getId();
	//dd($contactus->getData('contact_address'));
   return $this->render('home/contactus.html.twig', [
            'contact' => $contactus,
        ]);
    }
     
     
        public function home(WorkUnitRepository $workUnitRepository): Response
    {
        return $this->render('homepage.html.twig', [
            'work_units' => $workUnitRepository->findAll(),
        ]);
    }

public function testindex(MessageBusInterface $bus)
    {
        // will cause the SmsNotificationHandler to be called
        $bus->dispatch(new SmsNotification('Look! I created a message!'));

        // or use the shortcut
        $this->dispatchMessage(new SmsNotification('Look! I created a message!'));

        // ...
    }
    
      public function lang(Request $request) {
        $referer = $request->headers->get('referer');
        if ($referer == NULL) {
            $url = $this->router->generate('fallback_url');
        } else {
            $url = $referer;
        }
        return $this->redirect($referer);
    }

    public function onKernelRequest(GetResponseEvent $event) {
        $request = $event->getRequest();
        $locale = $request->getLocale(); 
//        echo $locale;
//        die();
        // some logic to determine the $locale
        $request->setLocale($locale);
    }
    
}
