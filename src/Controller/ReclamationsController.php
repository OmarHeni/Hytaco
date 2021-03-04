<?php

namespace App\Controller;

use App\Entity\Reclamations;
use App\Form\ReclamationsType;
use App\Repository\ReclamationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReclamationsController extends AbstractController
{
    /**
     * @Route("/reclamationss", name="reclamationsss")
     */
    public function index(): Response
    {
        return $this->render('reclamations/acceuil.htmltwig', [
            'controller_name' => 'ReclamationsController',
        ]);
    }
    /**
     * @Route("/SupprimerReclamations/{id}",name="deletereclamations")
     */
    function Delete($id,ReclamationsRepository $repository)
    {
        $reclamations=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($reclamations);
        $em->flush();//mise a jour
        return $this->redirectToRoute('ajouterreclamations');
    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/reclamation",name="ajouterreclamations")
     */
    function Add(Request $request)
    {
        $reclamations=new Reclamations();
        $form=$this->createForm(ReclamationsType::class, $reclamations);
        $en=$this->getDoctrine()->getManager()->getRepository(Reclamations::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($reclamations);
            $em->flush();
            return $this->redirectToRoute('ajouterreclamations');
        }
        return $this->render('back/reclamations.html.twig',
            [
                'form'=>$form->createView(), 'reclam'=>$en
            ]
        );
    }

    /**
     * @param Request $request
     * @Route("/ModifierReclamations/{id}",name="modifierreclamations")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(ReclamationsRepository $repository,$id,Request $request)
    {
        $reclamations=$repository->find($id);
        $form=$this->createForm(ReclamationsType::class,$reclamations);
        $en=$this->getDoctrine()->getManager()->getRepository(Reclamations::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('ajouterreclamations');
        }
        return $this->render('back/reclamations.html.twig',
            [
                'form'=>$form->createView(), 'reclam'=>$en
            ]
        );
    }
}
