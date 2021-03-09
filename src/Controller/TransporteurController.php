<?php

namespace App\Controller;

use App\Entity\Transporteur;
use App\Form\TransporteurType;
use App\Repository\TransporteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransporteurController extends AbstractController
{
    /**
     * @Route("/transporteursss", name="transporteurss")
     */
    public function index(): Response
    {
        return $this->render('back/transporteur.html.twig', [
            'controller_name' => 'TransporteurController',
        ]);
    }
    /**
     * @Route("/SupprimerTransporteur/{id}",name="deletetransporteur")
     */
    function Delete($id,TransporteurRepository $repository)
    {
        $transporteur=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($transporteur);
        $em->flush();//mise a jour
        return $this->redirectToRoute('ajoutertransporteur');
    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/transporteurs",name="ajoutertransporteur")
     */
    function Add(Request $request)
    {
        $user=$this->getUser();
        $transporteur=new Transporteur();
        $form=$this->createForm(TransporteurType::class, $transporteur);
        $en=$this->getDoctrine()->getManager()->getRepository(Transporteur::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($transporteur);
            $em->flush();
            return $this->redirectToRoute('ajoutertransporteur');
        }
        return $this->render('back/transporteur.html.twig',
            [
                'form'=>$form->createView(), 'trans'=>$en, 'us'=>$user
            ]
        );
    }


    /**
     * @param Request $request
     * @Route("/ModifierTransporteur/{id}",name="modifiertransporteur")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(TransporteurRepository $repository,$id,Request $request)
    {
        $transporteur=$repository->find($id);
        $form=$this->createForm(TransporteurType::class,$transporteur);
        $en=$this->getDoctrine()->getManager()->getRepository(Transporteur::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('ajoutertransporteur');
        }
        return $this->render('back/transporteur.html.twig',
            [
                'form'=>$form->createView(), 'trans'=>$en
            ]
        );
    }
}
