<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Repository\StageRepository;
use App\Repository\EntrepriseRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EntrepriseType;
use App\Form\StageType;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="pro_stages_accueil")
     */
    public function index(StageRepository $stageRepo)
    {
        return $this->render('pro_stages/index.html.twig');
    }

    /**
     * @Route("/entreprises", name="pro_stages_entreprises")
     */
    public function afficherEntreprises(EntrepriseRepository $entrepriseRepo)
    {
        return $this->render('pro_stages/afficherEntreprises.html.twig',["listeEntreprise" => $entrepriseRepo->findAll()]);
    }

    /**
     * @Route("/entreprise/{nom}", name="pro_stages_entreprise_en_particulier")
     */
    public function afficherEntreprise($nom, StageRepository $stageRepo)
    {
        return $this->render('pro_stages/afficherStagesEntreprise.html.twig',["listeStages" => $stageRepo->findStagesEntreprise($nom)]);
    }
	
	/**
     * @Route("/creer-entreprise", name="pro_stages_creer_entreprise")
     */
    public function creerEntreprise(Request $requete)
    {
		$entreprise = new Entreprise();
		$formulaireEntreprise = $this->CreateForm(EntrepriseType::class, $entreprise);
        $formulaireEntreprise->handleRequest($requete);
        
		// gestion de l'ajout du formulaire en BD
		if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid()){
			$manager = $this->getDoctrine()->getManager();
			$manager->persist($entreprise);
			$manager->flush();
			return $this->redirectToRoute('pro_stages_entreprises');
		}
		
        return $this->render('pro_stages/nouvelleEntreprise.html.twig',['vueFormulaire' => $formulaireEntreprise->createView()]);
    }
	/**
     * @Route("/modifier-entreprise/{id}", name="pro_stages_modifier_entreprise")
     */
    public function modifierStage(Request $requete, Entreprise $entreprise)
    {
		$formulaireEntreprise = $this->CreateForm(EntrepriseType::class, $entreprise);
        $formulaireEntreprise->handleRequest($requete);
        
		// gestion de l'ajout du formulaire en BD
		if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid()){
			$manager = $this->getDoctrine()->getManager();
			$manager->persist($entreprise);
			$manager->flush();
			return $this->redirectToRoute('pro_stages_entreprises');
		}
		
    return $this->render('pro_stages/modifierEntreprise.html.twig',['vueFormulaire' => $formulaireEntreprise->createView()]);
    }
}