<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $settings = new SiteSetting();

        // $settings->setId(1);
        // $settings->setName('Jimma University Research Portal');
        // $settings->setPrefix('RMS');
        // $manager->persist($settings);

        // $manager->flush();
    }
}
