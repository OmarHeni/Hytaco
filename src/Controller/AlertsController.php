<?php

namespace App\Controller;

use App\Entity\Alerts;
use App\Form\AlertsType;
use App\Repository\AlertsRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AlertsController extends AbstractController
{
    /**
     * @Route("/alertss", name="afficheralertes")
     */
    public function index(): Response
    {
        return $this->render('back/alertes.html.twig', [
            'controller_name' => 'AlertsController',
        ]);
    }

    /**
     * @Route("/SupprimerAlertes/{id}",name="deletealertes")
     */
    function Delete($id,AlertsRepository $repository)
    {
        $alertes=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($alertes);
        $em->flush();//mise a jour
        return $this->redirectToRoute('ajouteralertes');
    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/alerts",name="ajouteralertes")
     */
    function Add(Request $request)
    {
        $alerts=new Alerts();
        $form=$this->createForm(AlertsType::class, $alerts);
        $en=$this->getDoctrine()->getManager()->getRepository(Alerts::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($alerts);
            $em->flush();
            return $this->redirectToRoute('ajouteralertes');
        }
        return $this->render('back/alertes.html.twig',
            [
                'form'=>$form->createView(), 'aler'=>$en
            ]
        );
    }


    /**
     * @param Request $request
     * @Route("/ModifierAlerts/{id}",name="modifieralerts")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(AlertsRepository $repository,$id,Request $request)
    {
        $alerts=$repository->find($id);
        $form=$this->createForm(AlertsType::class,$alerts);
        $en=$this->getDoctrine()->getManager()->getRepository(Alerts::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('ajouteralertes');
        }
        return $this->render('back/alertes.html.twig',
            [
                'form'=>$form->createView(), 'aler'=>$en
            ]
        );
    }



}
