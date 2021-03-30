<?php

namespace App\Controller;

use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Entity\Locaux;
use Doctrine\ORM\EntityManagerInterface;
use Geocoder\Query\GeocodeQuery;
use Geocoder\Query\ReverseQuery;

class FrontaccController extends AbstractController
{
    /**
     * @Route("/accueil", name="frontacc")
     */
    public function index(Request $request): Response
    {
        $enl=$this->getDoctrine()->getManager()->getRepository(Locaux::class)->findAll();

        $en=$this->getDoctrine()->getManager()->getRepository(Categories::class)->findAll();
        return $this->render('front/acceuil.html.twig', [
            'cat' => $en,'locx'=>$enl
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
     * @Route("/contactf", name="fcontact")
     */
    public function contact(): Response
    {
        $httpClient = new \Http\Adapter\Guzzle6\Client();
        $provider = new \Geocoder\Provider\GoogleMaps\GoogleMaps($httpClient, null, 'AIzaSyB0zkek9cGyGPwkFIYy8uNhbzppD_s4gpE');
        $geocoder = new \Geocoder\StatefulGeocoder($provider, 'en');
        $result = $geocoder->geocodeQuery(GeocodeQuery::create('Buckingham Palace, London'));
        return $this->render('front/contact.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }


    /**
     * @Route("/connexionf", name="frontconnect")
     */
    public function connexion(): Response
    {
        return $this->render('front/connexion.html.twig', [
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
     * @Route("/commentairef", name="frontcommentaire")
     */

    public function AjouterCommentaire(Request $request,CommentaireRepository $comp)
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $coms = $comp->findAll();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('frontcommentaire');
        }
        return $this->render('front/frontacc/commentaires.html.twig', ['form' => $form->createView(),'coms'=>$coms
        ]);
    }

    /**
     * @Route("/supprimer{id}", name="supprimer")
     */
    public function delete (CommentaireRepository $comp,$id,  EntityManagerInterface $entityManager){
        $com=  $comp->find($id);
        $entityManager->remove($com);
        $entityManager->flush();
        return $this->redirectToRoute('frontcommentaire');
    }

}
