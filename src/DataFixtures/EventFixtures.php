<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Service\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    private $slugger;

    /**
     * EventFixtures constructor.
     * @param $slugger
     */
    public function __construct(Slugger $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        $event1 = new Event();
        $event1->setTitle("West Web Festival");
        $event1->setSlug($this->slugger->slugify($event1->getTitle()));
        $event1->setPicture("logo-wwf-2019.png");
        $event1->setCity($this->getReference("city-rennes"));
        $event1->addLanguage($this->getReference("language-french"));
        $event1->setUser($this->getReference("user-admin"));
        $event1->setIsValid();
        $event1->setDescription("Lorem ipsum... ");
        $event1->setDateStart(new \DateTime("2019-06-22"));
        $event1->setDateEnd(new \DateTime("2019-06-26"));
        $event1->setUrl("https://www.west-web-festival.fr/");
        $event1->setPrice(398);
        $manager->persist($event1);
        $this->setReference("event-west",$event1);

        $event2 = new Event();
        $event2->setTitle("Open Source Summit");
        $event2->setSlug($this->slugger->slugify($event2->getTitle()));
        $event2->setPicture("open-source-summit.jpg");
        $event2->setCity($this->getReference("city-rennes"));
        $event2->addLanguage($this->getReference("language-english"));
        $event2->setUser($this->getReference("user-admin"));
        $event2->setIsValid();
        $event2->setDescription("Lorem ipsum... ");
        $event2->setDateStart(new \DateTime("2019-08-06"));
        $event2->setDateEnd(new \DateTime("2019-08-10"));
        $event2->setUrl("https://www.opensourcesummit.paris/");
        $event2->setPrice(0);
        $manager->persist($event2);
        $this->setReference("event-open",$event2);

        $event3 = new Event();
        $event3->setTitle("Big Data Paris");
        $event3->setSlug($this->slugger->slugify($event3->getTitle()));
        $event3->setPicture("bigdata.jpg");
        $event3->setCity($this->getReference("city-paris"));
        $event3->addLanguage($this->getReference("language-french"));
        $event3->addLanguage($this->getReference("language-english"));
        $event3->setUser($this->getReference("user-john"));
        $event3->setIsValid();
        $event3->setDescription("Lorem ipsum... ");
        $event3->setDateStart(new \DateTime("2019-03-15"));
        $event3->setDateEnd(new \DateTime("2019-03-17"));
        $event3->setUrl("https://www.blogdumoderateur.com/evenements/big-data-paris/");
        $event3->setPrice(790);
        $manager->persist($event3);
        $this->setReference("event-big",$event3);

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
            LanguageFixtures::class,
            CityFixtures::class,
            UserFixtures::class
        ];
    }
}