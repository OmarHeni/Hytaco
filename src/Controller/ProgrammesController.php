<?php

namespace App\Controller;

use App\Entity\Programmes;
use App\Form\ProduitsType;
use App\Form\ProgrammesType;
use App\Repository\ProduitsRepository;
use App\Repository\ProgrammesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgrammesController extends AbstractController
{
    /**
     * @Route("/programmess", name="programmesss")
     */
    public function index(): Response
    {
        return $this->render('programmes/acceuil.htmltwig', [
            'controller_name' => 'ProgrammesController',
        ]);
    }
    /**
     * @Route("/programmesf", name="programmesf")
     */
    public function affprog(): Response
    {
        $en=$this->getDoctrine()->getManager()->getRepository(Programmes::class)->findAll();
        return $this->render('front/programmes.html.twig', [
            'controller_name' => 'ProgrammesController','progs'=>$en
        ]);
    }
    /**
     * @Route("/Participe", name="participer")
     */
    public function participe(Request $request): Response
    {
        /** @var Programmes $prog */
        $prog=$this->getDoctrine()->getManager()->getRepository(Programmes::class)->find($request->get('idp'));
        if ($this->getUser()) {
            $prog->addParticipant($this->getUser());
            $this->getDoctrine()->getManager()->flush();
            return $this->json(['message'=>'Vous avez été ajouté avec sucess'],200);
        }else {
            return $this->json(['message'=>'Veuillez se connecter']);
        }
    }
    /**
     * @Route("/SupprimerProgrammes/{id}",name="deleteprogrammes")
     */
    function Delete($id,ProgrammesRepository $repository)
    {
        $programmes=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($programmes);
        $em->flush();//mise a jour
        return $this->redirectToRoute('ajouterprogrammes');
    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/programmes",name="ajouterprogrammes")
     */
    function Add(Request $request,\Swift_Mailer $mailer)
    {
        $programmes=new Programmes();
        $us= $this->getUser();
        $form=$this->createForm(ProgrammesType::class, $programmes);
        $en=$this->getDoctrine()->getManager()->getRepository(Programmes::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $message = (new \Swift_Message('Nouvelle programme'))
                ->setFrom('HYTACOCAMPII@gmail.com')
                ->setTo($programmes->getTransporteur()->getMail())
                ->setBody(
                    'Vouz etes le transporteur du programme '.$programmes->getNom());
            $status= $mailer->send($message);
            $em=$this->getDoctrine()->getManager();
            $em->persist($programmes);
            $em->flush();
            return $this->redirectToRoute('ajouterprogrammes');
        }

        return $this->render('back/programmes.html.twig',
            [
                'form'=>$form->createView(), 'prog'=>$en,'us'=>$us
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/programmesfront",name="ajouterprogrammesfront")
     */
    function Addfront(Request $request,\Swift_Mailer $mailer)
    {
        $programmes=new Programmes();
        $us= $this->getUser();
        $form=$this->createForm(ProgrammesType::class, $programmes);
        $en=$this->getDoctrine()->getManager()->getRepository(Programmes::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $message = (new \Swift_Message('Nouvelle programme'))
                ->setFrom('HYTACOCAMPII@gmail.com')
                ->setTo($programmes->getTransporteur()->getMail())
                ->setBody(
                    'Vouz etes le transporteur du programme '.$programmes->getNom());
            $status= $mailer->send($message);
            $em=$this->getDoctrine()->getManager();
            $em->persist($programmes);
            $em->flush();
            return $this->redirectToRoute('ajouterprogrammesfront');
        }

        return $this->render('front/ajouterprogramme.html.twig',
            [
                'form'=>$form->createView(), 'prog'=>$en,'us'=>$us
            ]
        );
    }


    /**
     * @param Request $request
     * @Route("/ModifierProgrammes/{id}",name="modifierprogrammes")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(ProgrammesRepository $repository,$id,Request $request)
    {
        $programmes=$repository->find($id);
        $us= $this->getUser();
        $form=$this->createForm(ProgrammesType::class,$programmes);
        $en=$this->getDoctrine()->getManager()->getRepository(Programmes::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('ajouterprogrammes');
        }
        return $this->render('back/programmes.html.twig',
            [
                'form'=>$form->createView(), 'prog'=>$en,'us'=>$us
            ]
        );
    }



}
