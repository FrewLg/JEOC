<?php

 
 
namespace App\Controller;

use App\Entity\User;
use App\Entity\UserInfo;
use App\Form\FetchUASFormType; 
use App\Form\RegistrationFormType;
use App\Helper\MailHelper;
use App\Security\EmailVerifier;
use App\Security\LoginFormAuthenticator;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, MailHelper $mailHelper,  ContainerInterface $containerInterface, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();


        $is_external=true;
        $user = new User();
        $user2 = new User();

        // dd($request);
        $uas_form = $this->createForm(FetchUASFormType::class, $user2);

        $form = $this->createForm(RegistrationFormType::class, $user);
        $uas_form->handleRequest($request);
        
        $form->handleRequest($request);

        /**
         * to control tabs 
         */
        if($uas_form->isSubmitted()){
       
            $is_external=false;
        }
 
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password

          
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            // dd();

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                $user,
                (new TemplatedEmail())
                    ->from(new Address('firewlegese74@gmail.com', 'Jimma University Research Directorate Office'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
         
            $this->addFlash("success","Registered Successfully!!");
            // dd();
           
            return $this->redirectToRoute("app_login");
        }
        if ($uas_form->isSubmitted() && $uas_form->isValid()) {
            $username = $uas_form->get('username')->getData();
            if ($entityManager->getRepository(User::class)->findOneBy(["username" => $username])) {

                $this->addFlash("warning", "this user already exists");
            } else {

                try {

                    $client = HttpClient::create(['verify_peer' => false, 'verify_host' => false]);
                    $response = $client->request(
                        'POST',
                        sprintf('%s/user-api/get-user', $containerInterface->getParameter("uas_host")),
                        [
                            'headers' => [
                                'Accept' => 'application/json',
                                'X-AUTH-TOKEN' => $containerInterface->getParameter("uas_token"),
                            ],

                            'body' => ['username' => $username],
                        ],
                    );
                    $statusCode = $response->getStatusCode();
                    $content = $response->getContent();
                    $content = $response->toArray();
                    //  dd($statusCode, $content);
                   $hashed_password = $passwordEncoder->encodePassword($user, $uas_form->get('password')->getData());
                   // dd($content['data']['password'], $hashed_password);
                    if ($statusCode == 200 && $content['data'] &&  sizeof($content['data']) > 0 ) {

                        $userInfo=new UserInfo();
                        $data = $content['data'];
                        if($data['userType']=="Employee"){
                        $userInfo->setFirstName($data['firstName']);
                        $userInfo->setMidleName($data['middleName']);
                        $userInfo->setLastName($data['lastName']);
                        $user->setIsReviewer(1);
                        $user->setEmail($data['alternativeEmail']);
                        $user->setPassword($data['password']);
                        $userInfo->setPhoneNumber($data['phone']);
                        $userInfo->setGender($data['gender']);
                        $user->setPassword($hashed_password);
                        $entityManager->persist($user);
                        $userInfo->setUser($user);
                        $entityManager->persist($userInfo);
                        $entityManager->flush();


                        return $guardHandler->authenticateUserAndHandleSuccess(
                            $user,
                            $request,
                            $authenticator,
                            'main' // firewall name in security.yaml
                        );
                        $this->addFlash("success","Registered Successfully!!");
                        return $this->redirectToRoute("myprofile");
                    }else{
                        $uas_form->addError(new FormError("This User is not staff "));
                        
                    }

                    } else {
                        $uas_form->addError(new FormError("user not found"));
                    }
                } catch (\Throwable $th) {
                    // dd(2342);

                    $uas_form->addError(new FormError($th->getMessage()));
                }
            }
        }
       

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'uas_form' => $uas_form->createView(),
            'is_external' =>  $is_external,
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request, UserRepository $userRepository): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}
