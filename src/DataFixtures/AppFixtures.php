<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\Formation;

class AppFixtures extends Fixture
{
	public function load(ObjectManager $manager)
{
    // creation d'un générateur de données faker
    $faker = \Faker\Factory::create('fr_FR'); // create a French faker
    $formations = array("DUT Informatique","LP Multimedia","DU TIC");
    // création de formations
    foreach ($formations as $form) {
        $formation = new Formation();
        $formation->setNom($form);
        $manager->persist($formation);
		// création d'entreprises
        $nbEntreprises=$faker->numberBetween(5,7);
		for($i=1; $i<=$nbEntreprises; $i++){
		$entreprise = new Entreprise();
            $entreprise->setNom($faker->company());
            $entreprise->setActivite($faker->jobTitle());
            $entreprise->setAdresse($faker->streetAddress());
            $entreprise->setLienSiteWeb($faker->regexify('www\.'.$entreprise->getNom().'\.com'));
            $manager->persist($entreprise);
            // création de stages liées à une formation et à une entreprise
            $nbStages=$faker->numberBetween(2,3);
            for($y=1; $y<=$nbStages; $y++){
                $stage = new Stage();
                $stage->setTitre($faker->jobTitle());
                $stage->setDescription($faker->realText($maxNbChars = 200, $indexSize = 2));
                $stage->setEmailContact($faker->companyEmail());
                $stage->setDomaine($faker->jobTitle());
                $stage->addFormation($formation);
                $formation->addStage($stage);
                $stage->setEntreprise($entreprise);
                $entreprise->addStage($stage);
                $manager->persist($stage);
            }
			}
			
			 $manager->flush();
		}
	}
}	