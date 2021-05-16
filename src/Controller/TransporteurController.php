<?php

namespace App\Controller;

use App\Entity\Evenements;
use App\Entity\Programmes;
use App\Entity\Transporteur;
use App\Form\TransporteurType;
use App\Repository\TransporteurRepository;
use App\Repository\UtilisateurRepository;
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
                'form'=>$form->createView(), 'trans'=>$en
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/addtransporteur/{nom}/{adresse}/{numero}/{type}/{mail}",name="addtran")
     */
    function Addtran($nom,$adresse,$numero,$type,$mail)
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
     * @Route ("/addEven/{nom}/{date}/{nbrplace}/{datef}/{Lieu}",name="addeven")
     */
    function AddEven($nom,$date,$nbrplace,$datef,$Lieu)
    {
        $tran = new Evenements();
        $tran->setNom($nom)
            ->setDate($date)
            ->setNbrplace($nbrplace)
            ->setDatef($datef)
            ->setLieu($Lieu);

        $em=$this->getDoctrine()->getManager();
        $em->persist($tran);
        $em->flush();
        return $this->redirectToRoute('ajouterevenement');

    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/addEven/{nom}/{date}/{details}/{duree}",name="addeven")
     */
    function AddProg($nom,$details,$nbrplace,$datef,$Lieu)
    {
        $tran = new Programmes();
        $tran->setNom($nom)
            ->setDate($date)
            ->setNbrplace($nbrplace)
            ->setDatef($datef)
            ->setLieu($Lieu);

        $em=$this->getDoctrine()->getManager();
        $em->persist($tran);
        $em->flush();
        return $this->redirectToRoute('ajouterevenement');

    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/transporteurf",name="ajoutertransporteurf")
     */
    function Addf(Request $request,\Swift_Mailer $mailer,UtilisateurRepository $up)
    {
        $trans=new Transporteur();
        $en=$this->getDoctrine()->getManager()->getRepository(Transporteur::class)->findAll();
        $form=$this->createForm(TransporteurType::class, $trans);
        $users= $up->findBy([],[],3);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            foreach ($users as $user) {
                $message = (new \Swift_Message('Demande Transporteur'))
                    ->setFrom('hytacocampi@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView('front/demande.html.twig',
                            ['type' => 'transporteur','nom'=>$trans->getNom(),'adresse'=>$trans->getAdresse(),
                                'numero'=>$trans->getNumero(),'mail'=>$trans->getMail(),'typet'=>$trans->getType()]
                        ),
                        'text/html'
                    );
                $status = $mailer->send($message);
            }
            return $this->redirectToRoute('frontacc');
        }
        return $this->render('back/transporteur.html.twig',
            [
                'form'=>$form->createView(), 'trans'=>$en
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
