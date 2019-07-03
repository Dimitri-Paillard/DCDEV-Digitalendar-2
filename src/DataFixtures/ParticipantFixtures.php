<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ParticipantFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $participant1 = new Participant();
        $participant1->setCreatedAt(new \DateTime("2019-07-01"));
        $participant1->setUser($this->getReference("user-admin"));
        $participant1->setEvent($this->getReference("event-open"));
        $manager->persist($participant1);

        $participant2 = new Participant();
        $participant2->setCreatedAt(new \DateTime("2019-07-01"));
        $participant2->setUser($this->getReference("user-john"));
        $participant2->setEvent($this->getReference("event-west"));
        $manager->persist($participant2);

        $manager->flush();
    }
    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            EventFixtures::class,
            UserFixtures::class
        ];
    }
}