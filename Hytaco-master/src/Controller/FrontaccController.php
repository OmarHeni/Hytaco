<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontaccController extends AbstractController
{
    /**
     * @Route("/accueil", name="frontacc")
     */
    public function index(): Response
    {
        return $this->render('front/acceuil.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }

    /**
     * @Route("/comptef", name="frontcompte")
     */
    public function compte(): Response
    {
        return $this->render('front/compte.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }


    /**
     * @Route("/alertsf", name="alertesfff")
     */
    public function alets(): Response
    {
        return $this->render('front/alertes.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }

    /**
     * @Route("/visitorf", name="frontcomptee")
     */
    public function visitor(): Response
    {
        return $this->render('front/visitor.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }

    /**
     * @Route("/produitf", name="frontproduits")
     */
    public function produits(): Response
    {
        return $this->render('front/produits.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }

    /**
     * @Route("/commandef", name="frontcommande")
     */
    public function commandes(): Response
    {
        return $this->render('front/commandes.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }


    /**
     * @Route("/programmef", name="frontprogrammes")
     */
    public function programmes(): Response
    {
        return $this->render('front/programmes.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }



    /**
     * @Route("/profilef", name="frontprofile")
     */
    public function profile(): Response
    {
        return $this->render('front/profile.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }

    /**
     * @Route("/evenementf", name="frontevenements")
     */
    public function evenements(): Response
    {
        return $this->render('front/evenements.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }

}
