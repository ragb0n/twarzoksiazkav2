<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $currentDateTime = new \DateTime();

        $user = new User();
        $user->setFirstName("Mateusz");
        $user->setMiddleName("Łukasz");
        $user->setLastName("Olejnik");
        $user->setUsername("Olej");
        $user->setMobile("111-222-333");
        $user->setEmail("mati@olej.pl");
        $user->setJoinDate($currentDateTime);
        $user->setBio("Jestem pół człowiek, pół litra");
        $manager->persist($user);

        $user2 = new User();
        $user2->setFirstName("Łukasz");
        $user2->setLastName("Wajda");
        $user2->setUsername("Lukio");
        $user2->setMobile("444-555-666");
        $user2->setEmail("lukasz@wajda.pl");
        $user2->setJoinDate($currentDateTime);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setFirstName("Patryk");
        $user3->setMiddleName("Jan");
        $user3->setLastName("Marcinków");
        $user3->setUsername("Bursha");
        $user3->setMobile("777-888-999");
        $user3->setEmail("patryk@marc.pl");
        $user3->setJoinDate($currentDateTime);
        $user3->setBio("Moje ręce sa jak przewody, mogą...");
        $manager->persist($user3);

        $user4 = new User();
        $user4->setFirstName("Marcel");
        $user4->setLastName("Ławrynowicz");
        $user4->setUsername("Mrclpl");
        $user4->setMobile("000-111-222");
        $user4->setEmail("mrclp@gmail.pl");
        $user4->setJoinDate($currentDateTime);
        $manager->persist($user4);

        $user5 = new User();
        $user5->setFirstName("Marcel");
        $user5->setLastName("Ławrynowicz");
        $user5->setUsername("Mrclpl");
        $user5->setMobile("000-111-222");
        $user5->setEmail("mrclp@gmail.pl");
        $user5->setJoinDate($currentDateTime);
        $manager->persist($user5);

        $user6 = new User();
        $user6->setFirstName("Marcel");
        $user6->setLastName("Ławrynowicz");
        $user6->setUsername("Mrclpl");
        $user6->setMobile("000-111-222");
        $user6->setEmail("mrclp@gmail.pl");
        $user6->setJoinDate($currentDateTime);
        $manager->persist($user6);

        $user7 = new User();
        $user7->setFirstName("Marcel");
        $user7->setLastName("Ławrynowicz");
        $user7->setUsername("Mrclpl");
        $user7->setMobile("000-111-222");
        $user7->setEmail("mrclp@gmail.pl");
        $user7->setJoinDate($currentDateTime);
        $manager->persist($user7);

        $user8 = new User();
        $user8->setFirstName("Marcel");
        $user8->setLastName("Ławrynowicz");
        $user8->setUsername("Mrclpl");
        $user8->setMobile("000-111-222");
        $user8->setEmail("mrclp@gmail.pl");
        $user8->setJoinDate($currentDateTime);
        $manager->persist($user8);

        $user9 = new User();
        $user9->setFirstName("Marcel");
        $user9->setLastName("Ławrynowicz");
        $user9->setUsername("Mrclpl");
        $user9->setMobile("000-111-222");
        $user9->setEmail("mrclp@gmail.pl");
        $user9->setJoinDate($currentDateTime);
        $manager->persist($user9);
        
        $manager->flush();
    }
}