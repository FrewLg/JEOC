<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\EmailMessage;
// use Symfony\Component\Notifier\Message\EmailMessage;
class EmailMessageFixtures extends Fixture
{
     
    public function load(ObjectManager $manager)
    {
        $user = new EmailMessage();
        $user->setEmailKey('APPLY_SUCCESS');
        $user->setBody('Your application request has been successfully!');
        $user->setSubject("Successfully sent");
       $user = new EmailMessage();
        $user->setEmailKey('SUBMISSION_SUCCESS');
        $user->setBody('Your submission has been sent  successfully!');
        $user->setSubject("Successfully sent");
      
       $user = new EmailMessage();
        $user->setEmailKey('CALL_FOR_PROPOSAL_ANNOUNCEMENT');
        $user->setBody('New call has been announced!');
        $user->setSubject("New call for concept note");
      
        $manager->persist($user);
        $manager->flush();
    }        
}
