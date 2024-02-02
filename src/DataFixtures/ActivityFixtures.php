<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class ActivityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $Activity = new Activity();
        $Activity->setType('Sportive');
        $manager->persist($Activity);
        $this->addReference('type_Sportive', $Activity);

        $Activity = new Activity();
        $Activity->setType('Nature');
        $manager->persist($Activity);
        $this->addReference('type_Nature', $Activity);

        $Activity = new Activity();
        $Activity->setType('Culturelle');
        $manager->persist($Activity);
        $this->addReference('type_Culturelle', $Activity);

        $Activity = new Activity();
        $Activity->setType('Voyage');
        $manager->persist($Activity);
        $this->addReference('type_Voyage', $Activity);

        $Activity = new Activity();
        $Activity->setType('Créatif');
        $manager->persist($Activity);
        $this->addReference('type_Créatif', $Activity);

        $manager->flush();
    }
}
