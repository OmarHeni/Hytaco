<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use  Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
class BackaccController extends AbstractController
{
    /**
     * * @IsGranted("ROLE_ADMIN")
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {
        $us = $this->getUser();
        return $this->render('back/base.html.twig', [
            'us' => $us,
        ]);
    }



    /**
     * @Route("/map", name="blogmap")
     */
    public function map(): Response
    {
        return $this->render('back/maps.html.twig', [
            'controller_name' => 'BackaccController',
        ]);
    }


    /**
     * @Route("/fournisseur", name="blogfournisseur")
     */
    public function fournisseur(): Response
    {
        return $this->render('back/Fournisseurs.html.twig', [
            'controller_name' => 'BackaccController',
        ]);
    }
    /**
     * @Route("/listutili", name="bloglistutili")
     */
    public function listutili(): Response
    {
        return $this->render('back/list_utilisateurs.html.twig', [
            'controller_name' => 'BackaccController',
        ]);
    }


    /**
     * @Route("/preferences", name="blogperf")
     */
    public function preferences(): Response
    {
        return $this->render('back/preferences.html.twig', [
            'controller_name' => 'BackaccController',
        ]);
    }

    /**
     * @Route("/datav", name="blogdata")
     */
    public function datav(): Response
    {
        return $this->render('back/data-visualization.html.twig', [
            'controller_name' => 'BackaccController',
        ]);
    }

    /**
     * @Route("/manage", name="blogmanage")
     */
    public function manage(): Response
    {
        return $this->render('back/manage-users.html.twig', [
            'controller_name' => 'BackaccController',
        ]);
    }


    /**
     * @Route("/programmess", name="blogprogrammes")
     */
    public function programmes(): Response
    {
        return $this->render('back/programmes.html.twig', [
            'controller_name' => 'BackaccController',
        ]);
    }

    /**
     * @Route("/evenements", name="blogevenements")
     */
    public function evenements(): Response
    {
        return $this->render('back/evenements.html.twig', [
            'controller_name' => 'BackaccController',
        ]);
    }

    /**
     * @Route("/sponsors", name="blogsponsors")
     */
    public function sponsors(): Response
    {
        return $this->render('back/sponsors.html.twig', [
            'controller_name' => 'BackaccController',
        ]);
    }

    /**
     * @Route("/locauxx", name="bloglocaux")
     */
    public function locaux(): Response
    {
        return $this->render('back/locaux.html.twig', [
            'controller_name' => 'BackaccController',
        ]);
    }

    /**
     * @Route("/categories", name="blogcategories")
     */
    public function categories(): Response
    {
        return $this->render('back/categories.html.twig', [
            'controller_name' => 'BackaccController',
        ]);
    }

    /**
     * @Route("/produits", name="blogproduits")
     */
    public function produits(): Response
    {
        return $this->render('back/produits.html.twig', [
            'controller_name' => 'BackaccController',
        ]);
    }



    /**
     * @Route("/livraisons", name="bloglivraisons")
     */
    public function livraisons(): Response
    {
        return $this->render('back/livraisons.html.twig', [
            'controller_name' => 'BackaccController',
        ]);
    }


    /**
     * @Route("/livreurs", name="bloglivr")
     */
    public function livreurs(): Response
    {
        return $this->render('back/livreurs.html.twig', [
            'controller_name' => 'BackaccController',
        ]);
    }

    /**
     * @Route("/transporteur", name="blogtransporteur")
     */
    public function transporteur(): Response
    {
        return $this->render('back/transporteur.html.twig', [
            'controller_name' => 'BackaccController',
        ]);
    }

    /**
     * @Route("/alertes", name="blogalertes")
     */
    public function alertes(): Response
    {
        return $this->render('back/alertes.html.twig', [
            'controller_name' => 'BackaccController',
        ]);
    }

    /**
     * @Route("/reclamations", name="blogrec")
     */
    public function reclamations(): Response
    {
        return $this->render('back/reclamations.html.twig', [
            'controller_name' => 'BackaccController',
        ]);
    }

}
