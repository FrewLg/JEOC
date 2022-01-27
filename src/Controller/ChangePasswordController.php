<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Form\UpdatePasswordFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

/**
 * @Route("/change")
 */
class ChangePasswordController extends AbstractController
{

   /**
     * @Route("/password", name="uppass", methods={"GET","POST"})
     */
    public  function changepasswordnow(Request $request, UserPasswordEncoderInterface $passwordEncoder ,
      MailerInterface $mailer) : Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $user = $this->getUser();


        $form = $this->createForm(UpdatePasswordFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {  
            $encodedPassword = $passwordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData()
            );

               
            $old=  $passwordEncoder->encodePassword($user,  $form->get('password')->getData()  );
            // $oldfromform=  $passwordEncoder->encodePassword($user,  $user->getPassword() );
            // if($encodedPassword!=$old){
            // $this->addFlash('danger', "Old password do not match!   ");
            // return $this->redirectToRoute('change_password');            
            //   }
            
dd($form);

            $user->setPassword($encodedPassword);
            $this->getDoctrine()->getManager()->flush();
 
            // $this->cleanSessionAfterReset();

            $email = (new TemplatedEmail())
            ->from(new Address('no-reply@ju.edu.et', $this->getParameter('app_name')))
             ->to($user->getEmail())
            ->subject('Your password reset request')
            ->htmlTemplate('reset_password/changedemail.html.twig')
            ->context([
                'name' => $user->getUserInfo(),
            ])
        ;

        $mailer->send($email);
        $this->addFlash('success', "Password has been changed successfully !   ");


            return $this->redirectToRoute('homepage');
        }

        return $this->render('reset_password/new.html.twig', [
        
           'form' => $form->createView(),
       ]);
    }
}