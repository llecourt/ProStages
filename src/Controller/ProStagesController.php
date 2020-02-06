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
}