<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\UserInfo;
class UserFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    // ...
    public function load(ObjectManager $manager)
    {
        $user = new User();
        // $user->setId(1);
        $user->setUsername('admin');
        $user->setEmail('firewlesgese@ju.edu.et');
        $user->setIsVerified(true); 

        $password = $this->encoder->encodePassword($user, 'admin');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN','ROLE_USER','ROLE_EVALUATOR','usrgrp_act']); 
        $manager->persist($user);
        $manager->flush();

        $userinfo = new UserInfo();
         $userinfo->setUser($user); 
  
        $manager->persist($userinfo);
        $manager->flush();
    }        
}
