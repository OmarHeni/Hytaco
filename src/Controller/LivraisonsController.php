<?php

namespace App\Controller;

use App\Entity\Livraisons;
use App\Form\LivraisonsType;
use App\Repository\LivraisonsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class LivraisonsController extends AbstractController
{
    /**
     * @Route("/livraisonsss", name="livraisonss")
     */
    public function index(): Response
    {
        return $this->render('back/livraisons.html.twig', [
            'controller_name' => 'LivraisonsController',
        ]);
    }

    /**
     * @Route("/SupprimerLivraisons/{id}",name="deletelivraisons")
     */
    function Delete($id,LivraisonsRepository $repository)
    {
        $livraisons=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($livraisons);
        $em->flush();//mise a jour
        return $this->redirectToRoute('ajouterlivraisons');
    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/livraison",name="ajouterlivraisons")
     */
    function Add(Request $request)
    {
        $user=$this->getUser();
        $livraisons=new Livraisons();
        $form=$this->createForm(LivraisonsType::class, $livraisons);
        $en=$this->getDoctrine()->getManager()->getRepository(Livraisons::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($livraisons);
            $em->flush();
            return $this->redirectToRoute('ajouterlivraisons');
        }
        return $this->render('back/livraisons.html.twig',
            [
                'form'=>$form->createView(), 'livr'=>$en ,'us'=>$user
            ]
        );
    }


    /**
     * @param Request $request
     * @Route("/ModifierLivraisons/{id}",name="modifierlivraisons")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(LivraisonsRepository $repository,$id,Request $request)
    {
        $user=$this->getUser();
        $livaisons=$repository->find($id);
        $form=$this->createForm(LivraisonsType::class,$livaisons);
        $en=$this->getDoctrine()->getManager()->getRepository(Livraisons::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('ajouterlivraisons');
        }
        return $this->render('back/livraisons.html.twig',
            [
                'form'=>$form->createView(), 'livr'=>$en ,'us'=>$user
            ]
        );
    }
}
