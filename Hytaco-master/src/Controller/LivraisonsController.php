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
use Symfony\Component\EventDispatcher\EventSubscriberInterface ;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;

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
    function Delete($id,LivraisonsRepository $repository, \Swift_Mailer $mailer)
    {
        $livraisons=$repository->find($id);
        $body = 'La livrasion #'.strval($id).'a été supprimée';
       $message = (new \Swift_Message('Livraison annulé'))
            ->setFrom('HYTACOCAMPII@gmail.com')
            ->setTo($livraisons->getLivreur()->getMail())
            ->setBody($body);
        $mailer->send($message);
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
                'form'=>$form->createView(), 'livr'=>$en
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
                'form'=>$form->createView(), 'livr'=>$en
            ]
        );
    }


}
