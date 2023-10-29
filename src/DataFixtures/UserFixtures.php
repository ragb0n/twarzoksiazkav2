<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setName('Jan');
        $user->setSurname('Nowak');
        $user->setAge(42);
        $user->setCity($this->getReference('city')); //przypisanie wartości (klucza obcego) z tabeli "City"
        $user->setNickname("Mietek");
        $manager->persist($user);

        $user2 = new User();
        $user2->setName('Kamil');
        $user2->setSurname('Kowalski');
        $user2->setAge(25);
        $user2->setCity($this->getReference('city_1'));
        $manager->persist($user2);

        $user3 = new User();
        $user3->setName('Barbara');
        $user3->setSurname('Gruszka');
        $user3->setAge(63);
        $user3->setCity($this->getReference('city_1'));
        $user->setNickname("Ruda");
        $manager->persist($user3);

        $user4 = new User();
        $user4->setName('Grażyna');
        $user4->setSurname('Borowik');
        $user4->setAge(23);
        $user4->setCity($this->getReference('city_2'));
        $user->setNickname("Grażka");
        $manager->persist($user4);

        $user5 = new User();
        $user5->setName('Jan');
        $user5->setSurname('Nowak');
        $user5->setAge(42);
        $user5->setCity($this->getReference('city_2'));
        $manager->persist($user5);

        $manager->flush();


    }
}
