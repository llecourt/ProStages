<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="pro_stages_accueil")
     */
    public function index()
    {
        $rep=$this->getDoctrine()->getRepository(Stage::class);
        $stages=$rep->findAll();
        return $this->render('pro_stages/index.html.twig',["listeStages" => $stages]);
    }

    /**
     * @Route("/entreprises", name="pro_stages_entreprises")
     */
    public function afficherEntreprises()
    {
        $rep=$this->getDoctrine()->getRepository(Entreprise::class);
        $entreprises=$rep->findAll();
        return $this->render('pro_stages/afficherEntreprises.html.twig',["listeEntreprise" => $entreprises]);
    }

    /**
     * @Route("/entreprise/{id}", name="pro_stages_entreprise_en_particulier")
     */
    public function afficherEntreprise($id)
    {
        $rep=$this->getDoctrine()->getRepository(Stage::class);
        $stages=$rep->findBy(["entreprise"=>$id]);
        return $this->render('pro_stages/afficherStagesEntreprise.html.twig',["listeStages" => $stages]);
    }

    /**
     * @Route("/formations", name="pro_stages_formations")
     */
    public function afficherFormations()
    {
        $rep=$this->getDoctrine()->getRepository(Formation::class);
        $formations=$rep->findAll();
        return $this->render('pro_stages/afficherFormations.html.twig',["listeFormations" => $formations]);
    }

    /**
     * @Route("/formation/{id}", name="pro_stages_formation_en_particulier")
     */
    public function afficherFormation($id)
    {
        $repFormation=$this->getDoctrine()->getRepository(Formation::class);
        $formations=$repFormation->find($id);
        $stages=$formations->getStages();

        return $this->render('pro_stages/afficherStagesFormation.html.twig',["listeStages" => $stages]);
    }

    /**
     * @Route("/stage/{id}", name="pro_stages_stages")
     */
    public function afficherStages($id)
    {
        return $this->render('pro_stages/afficherStages.html.twig',['id'=>$id]);
    }
}
