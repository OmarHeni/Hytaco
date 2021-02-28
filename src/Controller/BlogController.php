<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/login", name="bloglog")
     */
    public function login(): Response
    {
        return $this->render('login.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/map", name="blogmap")
     */
    public function map(): Response
    {
        return $this->render('maps.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/profile", name="blogprofile")
     */
    public function profile(): Response
    {
        return $this->render('profile.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
    /**
     * @Route("/fournisseur", name="blogfournisseur")
     */
    public function fournisseur(): Response
    {
        return $this->render('Fournisseurs.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
    /**
     * @Route("/listutili", name="bloglistutili")
     */
    public function listutili(): Response
    {
        return $this->render('list_utilisateurs.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
    /**
     * @Route("/commandes", name="blogcommandes")
     */
    public function commandes(): Response
    {
        return $this->render('commandes.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/preferences", name="blogperf")
     */
    public function preferences(): Response
    {
        return $this->render('preferences.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/datav", name="blogdata")
     */
    public function datav(): Response
    {
        return $this->render('data-visualization.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/manage", name="blogmanage")
     */
    public function manage(): Response
    {
        return $this->render('manage-users.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/utilisateurs", name="blogutilisateurs")
     */
    public function utilisateurs(): Response
    {
        return $this->render('utilisateurs.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/programmes", name="blogprogrammes")
     */
    public function programmes(): Response
    {
        return $this->render('programmes.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/evenements", name="blogevenements")
     */
    public function evenements(): Response
    {
        return $this->render('evenements.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/sponsors", name="blogsponsors")
     */
    public function sponsors(): Response
    {
        return $this->render('sponsors.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/locaux", name="bloglocaux")
     */
    public function locaux(): Response
    {
        return $this->render('locaux.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/categories", name="blogcategories")
     */
    public function categories(): Response
    {
        return $this->render('categories.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/produits", name="blogproduits")
     */
    public function produits(): Response
    {
        return $this->render('produits.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }



    /**
     * @Route("/livraisons", name="bloglivraisons")
     */
    public function livraisons(): Response
    {
        return $this->render('livraisons.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }


    /**
     * @Route("/livreurs", name="bloglivr")
     */
    public function livreurs(): Response
    {
        return $this->render('livreurs.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/transporteur", name="blogtransporteur")
     */
    public function transporteur(): Response
    {
        return $this->render('transporteur.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/alertes", name="blogalertes")
     */
    public function alertes(): Response
    {
        return $this->render('alertes.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/reclamations", name="blogrec")
     */
    public function reclamations(): Response
    {
        return $this->render('reclamations.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

}
