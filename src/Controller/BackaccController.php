<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Produits;
use App\Form\AddUtilisateurType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use  Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BackaccController extends AbstractController
{

    private $em ;
    private $up ;
    public function __construct(UtilisateurRepository $up,EntityManagerInterface $em)
    {
        $this->up = $up;
        $this->em = $em ;
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/blog", name="bloggg")
     */
    public function utilisateuraffback (Request $request,UserPasswordEncoderInterface $encoder): Response
    {
        $session =  $request->getSession()->get('email');
        $produit=$this->getDoctrine()->getManager()->getRepository(Produits::class)->findAll();
        $us = $this->up->findOneBy(array('email'=>$session),array());
        $uss = $this->getUser();

        $user = new Utilisateur();
        $users = $this->up->findByRole('ROLE_FOUR');
        $form= $this->createForm(AddUtilisateurType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirect("/blog");
        }
        else {
            return $this->render('back/base.html.twig',
                ['form'=>$form->Createview(),'users'=>$users,'us'=>$us,'uss'=>$uss,'produit'=>$produit]);
        }

    }




    /**
     * @Route ("/fournisseurc/{id}",name="edit_four")
     */
    public function Edit_fournisseur($id,Request $request,UserPasswordEncoderInterface $encoder)
    {

        $uss = $this->getUser();
        $user = $this->up->findOneBy(array('id'=>$id));
        $form= $this->createForm(AddUtilisateurType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirect("/edit_four");
        }
        return $this->render('back/utilisateurfournisseurs.html.twig',
            ['form'=>$form->Createview(),'uss'=>$uss,'useer'=>$user]);
    }




    /**
     * @Route("/map", name="blogmap")
     */
    public function map(): Response
    {
        $user=$this->getUser();
        return $this->render('back/maps.html.twig', [
            'controller_name' => 'BackaccController','us'=>$user
        ]);
    }


    /**
     * @Route("/fournisseurs", name="blogfournisseur")
     */
    public function fournisseur(): Response
    {
        $user=$this->getUser();

        return $this->render('back/Fournisseurs.html.twig', [
            'controller_name' => 'BackaccController','uss'=>$user
        ]);
    }



    /**
     * @Route("/fournisseur", name="blogg")
     */
    public function fournisseurC (Request $request,UserPasswordEncoderInterface $encoder): Response
    {

$us = $this->getUser();
        $user = new Utilisateur();
        $users = $this->up->findAll();
        $form= $this->createForm(AddUtilisateurType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirect("/blog");
        }
        else {
            return $this->render('back/Fournisseurs.html.twig',
                ['form'=>$form->Createview(),'users'=>$users,'us'=>$us]);
        }

        //  $form = $this->createForm(UtilisateurAddType::class,$user)
    }


    /**
     * @Route("/listutili", name="bloglistutili")
     */
    public function listutili(): Response
    {
        $user=$this->getUser();
        return $this->render('back/list_utilisateurs.html.twig', [
            'controller_name' => 'BackaccController', 'us'=>$user
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
        $user=$this->getUser();
        $produit=$this->getDoctrine()->getManager()->getRepository(Produits::class)->findAll();
        return $this->render('back/data-visualization.html.twig', [
            'controller_name' => 'BackaccController','us'=>$user, 'produit'=>$produit
        ]);
    }

    /**
     * @Route("/manage", name="blogmanage")
     */
    public function manage(): Response
    {
        $user=$this->getUser();
        return $this->render('back/manage-users.html.twig', [
            'controller_name' => 'BackaccController','us'=>$user
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
    public function locauxx(): Response
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
