<?php

namespace App\Controller;

use App\Entity\Locaux;
use App\Form\LocauxType;
use App\Repository\LocauxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocauxController extends AbstractController
{
    /**
     * @Route("/locauxx", name="locauxxx")
     */
    public function index(): Response
    {
        return $this->render('locaux/acceuil.htmltwig', [
            'controller_name' => 'LocauxController',
        ]);
    }


    /**
     * @Route("/SupprimerLocaux/{id}",name="deletelocaux")
     */
    function Delete($id,LocauxRepository $repository)
    {
        $locaux=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($locaux);
        $em->flush();//mise a jour
        return $this->redirectToRoute('ajouterlocaux');
    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/locaux",name="ajouterlocaux")
     */
    function Add(Request $request)
    {
        $locaux=new Locaux();
        $user=$this->getUser();
        $form=$this->createForm(LocauxType::class, $locaux);
        $en=$this->getDoctrine()->getManager()->getRepository(Locaux::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($locaux);
            $em->flush();
            return $this->redirectToRoute('ajouterlocaux');
        }
        return $this->render('back/locaux.html.twig',
            [
                'form'=>$form->createView(), 'loc'=>$en, 'us'=>$user
            ]
        );
    }


    /**
     * @param Request $request
     * @Route("/ModifierLocaux/{id}",name="modifierlocaux")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(LocauxRepository $repository,$id,Request $request)
    {
        $locaux=$repository->find($id);
        $form=$this->createForm(LocauxType::class,$locaux);
        $en=$this->getDoctrine()->getManager()->getRepository(Locaux::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('ajouterlocaux');
        }
        return $this->render('back/locaux.html.twig',
            [
                'form'=>$form->createView(), 'loc'=>$en
            ]
        );
    }



}
