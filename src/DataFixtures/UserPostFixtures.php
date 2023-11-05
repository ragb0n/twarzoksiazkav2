<?php

namespace App\DataFixtures;

use App\Entity\UserPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserPostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $manager->flush();
    }
}