<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Repository\StageRepository;
use App\Repository\FormationRepository;
use App\Repository\EntrepriseRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EntrepriseType;
use App\Form\StageType;
use App\Form\FormationType;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="pro_stages_accueil")
     */
    public function index(StageRepository $stageRepo)
    {
        return $this->render('pro_stages/index.html.twig',["listeStages" => $stageRepo->findStagesEtEntreprises()]);
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
     * @Route("/formations", name="pro_stages_formations")
     */
    public function afficherFormations(FormationRepository $formationRepo)
    {
        return $this->render('pro_stages/afficherFormations.html.twig',["listeFormations" => $formationRepo->findAll()]);
    }

    /**
     * @Route("/formation/{nom}", name="pro_stages_formation_en_particulier")
     */
    public function afficherFormation($nom, StageRepository $stageRepo)
    {
        return $this->render('pro_stages/afficherStagesFormation.html.twig',["listeStages" => $stageRepo->findStagesFormation($nom)]);
    }

    /**
     * @Route("/stage/{id}", name="pro_stages_stages")
     */
    public function afficherStage($id, StageRepository $stageRepo)
    {
        return $this->render('pro_stages/afficherStage.html.twig',['stage' => $stageRepo->find($id)]);
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

	/**
     * @Route("/creer-stage", name="pro_stages_creer_stage")
     */
    public function creerStage(Request $requete)
    {
		$stage = new Stage();
		$form = $this->CreateForm(StageType::class, $stage);
        $form->handleRequest($requete);
        
		// gestion de l'ajout du formulaire en BD
		if($form->isSubmitted() && $form->isValid()){
			$manager = $this->getDoctrine()->getManager();
			$manager->persist($stage);
			$manager->flush();
			return $this->redirectToRoute('pro_stages_accueil');
		}
		
        return $this->render('pro_stages/nouveauStage.html.twig', ['vueFormulaire' => $form->createView()]);
    }
}