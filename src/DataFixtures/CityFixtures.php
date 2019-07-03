<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\City;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $city1 = new City();
        $city1->setName("Lannion");
        $manager->persist($city1);
        $this->setReference("city-lannion", $city1);

        $city2 = new City();
        $city2->setName("Paris");
        $manager->persist($city2);
        $this->setReference("city-paris", $city2);

        $city3 = new City();
        $city3->setName("Rennes");
        $manager->persist($city3);
        $this->setReference("city-rennes", $city3);

        $manager->flush();
    }
}
