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
        return $this->redirectToRoute('afficheralerts');
    }

    /**
     * @Route("/alerts",name="afficheralerts")
     */
    public function Affiche(AlertsRepository $repository)
    {
        $user=$this->getUser();
        $alerts=$repository->findAll();
        return $this->render('back/alertes.html.twig',
            ['aler'=>$alerts, 'us'=>$user]);
    }


    /**
     * @Route("/alertsff", name="alertesfff")
     */
    public function alets(): Response
    {
        return $this->render('front/alertes.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/alertsf",name="ajouteralertes")
     */
    function Add(Request $request)
    {
        $user=$this->getUser();
        $alerts=new Alerts();
        $alerts->setUtilisateur($user);

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
        return $this->render('front/alertes.html.twig',
            [
                'form'=>$form->createView(), 'aler'=>$en
            ]
        );
    }




}
