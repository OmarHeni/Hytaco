<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\ProduitsType;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProduitsController extends AbstractController
{
    /**
     * @Route("/produitindex", name="produitindex")
     */
    public function index(): Response
    {
        return $this->render('back/produits.html.twig', [
            'controller_name' => 'ProduitsController',
        ]);
    }


    /**
     * @Route("/SupprimerProduits/{id}",name="deleteproduits")
     */
    function Delete($id,ProduitsRepository $repository)
    {
        $produits=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($produits);
        $em->flush();//mise a jour
        return $this->redirectToRoute('ajouterproduits');
    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/produit",name="ajouterproduits")
     */
    function Add(Request $request)
    {
        $produits=new Produits();
        $form=$this->createForm(ProduitsType::class,$produits);
        $en=$this->getDoctrine()->getManager()->getRepository(Produits::class)->findAll();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($produits);
            $em->flush();
            return $this->redirectToRoute('ajouterproduits');
        }
        return $this->render('back/produits.html.twig',
            [
                'form'=>$form->createView(),'prod'=>$en
            ]
        );
    }


    /**
     * @param Request $request
     * @Route("/ModifierProduits/{id}",name="modifierproduits")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(ProduitsRepository $repository,$id,Request $request)
    {
        $produits=$repository->find($id);
        $form=$this->createForm(ProduitsType::class,$produits);
        $en=$this->getDoctrine()->getManager()->getRepository(Produits::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('ajouterproduits');
        }
        return $this->render('back/produits.html.twig',
            [
                'form'=>$form->createView(), 'prod'=>$en            ]
        );
    }

}
