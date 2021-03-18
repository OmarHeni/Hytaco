<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Produits;
use App\Entity\Publicite;
use App\Form\ProduitsType;
use App\Repository\ProduitsRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;

class ProduitsController extends AbstractController
{    private $up ;

    /**
     * @Route("/produitsolo", name="produitsolos")
     */
    public function produitsolo(Request $request)
    {
        $id =   $request->get('id');
        $ca=$this->getDoctrine()->getManager()->getRepository(Produits::class)->findBy(['id'=>$id]);
        return $this->render('front/produitsolo.html.twig', [
            'prod' => $ca
        ]);
    }



    /**
     * @Route("/produitf", name="frontproduitss")
     */
    public function produi(Request $request)
    {
        $id =   $request->get('id');
        $cas=$this->getDoctrine()->getManager()->getRepository(Categories::class)->findAll();
        $pubicite=$this->getDoctrine()->getManager()->getRepository(Publicite::class)->findAll();

        if ($id){
            $ca=$this->getDoctrine()->getManager()->getRepository(Categories::class)->findBy(['id'=>$id]);
            $en=$this->getDoctrine()->getManager()->getRepository(Produits::class)->findBy(['categorie'=>$ca]);
        }else {
            $en=$this->getDoctrine()->getManager()->getRepository(Produits::class)->findAll();
        }

        return $this->render('front/prod.html.twig', [             'prod' => $en,'cat'=>$cas,'pubicite' => $pubicite        ]);
    }

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
        return $this->redirectToRoute('ajouterproduitsa');
    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/produit",name="ajouterproduitsa")
     */
    function Add(Request $request,\Swift_Mailer $mailer)
    {
        $produits=new Produits();
        $user=$this->getUser();
        $form=$this->createForm(ProduitsType::class,$produits);
        $en=$this->getDoctrine()->getManager()->getRepository(Produits::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($produits);
            $message = (new \Swift_Message('Alerte!'))
                ->setFrom('HYTACOCAMPII@gmail.com')
                ->setTo($produits->getUtilisateur()->getEmail())
                ->setBody(
                    'Par cet email présent nous vous promosons ces numéros pour vous aider: 
                193          : Garde nationale.
                197          : Police nationale.
                198          : Protection civile.
                801111      : numéro vert.
                ,'
                );
            $mailer->send($message);
            $em->flush();
            return $this->redirectToRoute('ajouterproduitsa');
        }
        return $this->render('back/produits.html.twig',
            [
                'form'=>$form->createView(),'prod'=>$en, 'us'=>$user ,'uss'=>$user
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
        $user=$this->getUser();
        $produits=$repository->find($id);
        $form=$this->createForm(ProduitsType::class,$produits);
        $en=$this->getDoctrine()->getManager()->getRepository(Produits::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('ajouterproduitsa');
        }
        return $this->render('back/produits.html.twig',
            ['form'=>$form->createView(), 'prod'=>$en, 'uss'=>$user]);
    }

}
