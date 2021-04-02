<?php

namespace App\Controller;

use App\Entity\Transporteur;
use App\Form\TransporteurType;
use App\Repository\TransporteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use  Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


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
     * @Route ("/addtransporteur/{nom}/{adresse}/{numero}/{type}/{mail}",name="addtran")
     */
    function Addtran ($nom,$adresse,$numero,$type,$mail)
    {
        $tran = new Transporteur();
        $tran->setNom($nom)
            ->setAdresse($adresse)
            ->setMail($mail)
            ->setNumero($numero)
            ->setType($type);

        $em=$this->getDoctrine()->getManager();
        $em->persist($tran);
        $em->flush();
        return $this->redirectToRoute('ajoutertransporteur');

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/transporteurs",name="ajoutertransporteur")
     */
    function Add(Request $request,\Swift_Mailer $mailer)
    {
        $transporteur=new Transporteur();
        $user=$this->getUser();

        $form=$this->createForm(TransporteurType::class, $transporteur);
        $en=$this->getDoctrine()->getManager()->getRepository(Transporteur::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($transporteur);
            $message = (new \Swift_Message('Bienvenue'))
                ->setFrom('hytacocampi21@gmail.com')
                ->setTo($transporteur->getMail())
                ->setBody(
                    'Bienvenue, vous êtes officiellement le chauffeur de Hytaco, veuillez attendre votre affectation!'
                )
            ;
            $mailer->send($message);
            $em->flush();
            return $this->redirectToRoute('ajoutertransporteur');

        }

        return $this->render('back/transporteur.html.twig',
            [
                'form'=>$form->createView(), 'trans'=>$en,'us'=>$user
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
        $user=$this->getUser();
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
                'form'=>$form->createView(), 'trans'=>$en,'us'=>$user
            ]
        );
    }
    /**
     * @Route("tridesc",name="tridesc")
     */
    public function tridesc(TransporteurRepository $repo, Request $request)
    {

        $articles = $repo->tridesc();

        return $this->render('front/consult.html.twig', [
            'trans' => $articles,
        ]);
    }
    /**
     * @Route("triasc", name="triasc")
     */
    public function triasc(TransporteurRepository $repo, Request $request)
    {

        $articles =
            $repo->triasc();


        return $this->render('front/consult.html.twig', [
            'trans' => $articles,
        ]);
    }


}