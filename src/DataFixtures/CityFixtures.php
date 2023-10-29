<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $city = new City();
        $city->setName('Katowice');
        $manager->persist($city);

        $city1 = new City();
        $city1->setName('Warszawa');
        $manager->persist($city1);

        $city2 = new City();
        $city2->setName('Ozimek');
        $manager->persist($city2);

        $manager->flush();

        $this->addReference('city', $city);
        $this->addReference('city_1', $city1);
        $this->addReference('city_2', $city2);

    }
}
