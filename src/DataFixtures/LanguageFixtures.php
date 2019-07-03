<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Language;

class LanguageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $language1 = new Language();
        $language1->setName("Français");
        $manager->persist($language1);
        $this->setReference("language-french", $language1);

        $language2 = new Language();
        $language2->setName("Anglais");
        $manager->persist($language2);
        $this->setReference("language-english", $language2);

        $language3 = new Language();
        $language3->setName("Mandarin");
        $manager->persist($language3);
        $this->setReference("language-chinese", $language3);

        $language4 = new Language();
        $language4->setName("Allemand");
        $manager->persist($language4);
        $this->setReference("language-german", $language4);

        $manager->flush();
    }
}
