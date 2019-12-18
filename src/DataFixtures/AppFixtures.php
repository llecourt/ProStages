<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Entreprise;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $entreprise1 = new Entreprise();
        $entreprise1->setNom("Capgemini");
        $entreprise1->setActivite("Services");
        $entreprise1->setAdresse("4 rue Pierrot Lacaule");
        $entreprise1->setLienSiteWeb("www.capgemini.com");
        $manager->persist($entreprise1);
        $manager->flush();
    }
}
