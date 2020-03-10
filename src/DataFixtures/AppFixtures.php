<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\Formation;
use App\Entity\User;

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
    }
    $user1 = new User();
    $user1->setUsername("leo");
    $user1->setRoles(["ROLE_ADMIN"]);
    $user1->setPassword('$2y$10$Ng0spKpKFXu8shdHYjbLXuQOmSLHOnVCFpDHHKDpKY6Er1UZ7hASm');
    $manager->persist($user1);

    $user2 = new User();
    $user2->setUsername("thomas");
    $user2->setRoles(["ROLE_USER"]);
    $user2->setPassword('$2y$10$rc.L3oyLR26e4P/9GjPvo.rf5znoCs9JMLcftI0035ijKgVBEN8iS');
    $manager->persist($user2);

	$manager->flush();
	}
}	