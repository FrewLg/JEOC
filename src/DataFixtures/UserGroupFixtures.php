<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\UserGroup;
class UserGroupFixtures extends Fixture
{

    
    public function load(ObjectManager $manager)
    {
        // $user = new UserGroup();
        // // $user->setId(1);
        // $user->setName('College Coordinator');
        // $user->setDescription('College Coordinator');
  
        // $manager->persist($user);
        // $manager->flush();
    }        
}
