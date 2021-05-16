<?php

namespace App\Controller;

use App\Entity\Livraisons;
use App\Entity\Livreurs;
use App\Form\LivraisonsType;
use App\Form\LivreursType;
use App\Repository\LivreursRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LivreursController extends AbstractController
{
    /**
     * @Route("/livreurss", name="livreursss")
     */
    public function index(): Response
    {
        return $this->render('back/livreurs.html.twig', [
            'controller_name' => 'LivreursController',
        ]);
    }
    /**
     * @Route("/Supprimerlivreurs/{id}",name="deletelivreurs")
     */
    function Delete($id,LivreursRepository $repository)
    {
        $livreurs=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($livreurs);
        $em->flush();//mise a jour
        return $this->redirectToRoute('ajouterlivreurs');
    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/livreur",name="ajouterlivreurs")
     */
    function Add(Request $request)
    {
        $livreurs=new Livreurs();
        $form=$this->createForm(LivreursType::class, $livreurs);
        $en=$this->getDoctrine()->getManager()->getRepository(Livreurs::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($livreurs);
            $em->flush();
            return $this->redirectToRoute('ajouterlivreurs');
        }
        return $this->render('back/livreurs.html.twig',
            [
                'form'=>$form->createView(), 'liv'=>$en
            ]
        );
    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/addlivreur/{nom}/{adresse}/{telephone}/{mail}",name="addliv")
     */
    function Addliv($nom,$adresse,$telephone,$mail)
    {
        $livr = new Livreurs();
        $livr->setNom($nom)
            ->setAdresse($adresse)
            ->setMail($mail)
            ->setTelephone($telephone);
        $em=$this->getDoctrine()->getManager();
        $em->persist($livr);
        $em->flush();
        return $this->redirectToRoute('ajouterlivreurs');

    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/livreurf",name="ajouterlivreurs")
     */
    function Addf(Request $request,\Swift_Mailer $mailer,UtilisateurRepository $up)
    {
        $livreurs=new Livreurs();
        $en=$this->getDoctrine()->getManager()->getRepository(Livreurs::class)->findAll();
        $form=$this->createForm(LivreursType::class, $livreurs);
       $users= $up->findBy([],[],3);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            foreach ($users as $user) {
                $message = (new \Swift_Message('Demande livreur'))
                    ->setFrom('hytacocampi@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView('front/demande.html.twig',
                            ['type' => 'livreurs','nom'=>$livreurs->getNom(),'adresse'=>$livreurs->getAdresse(),
                                'telephone'=>$livreurs->getTelephone(),'mail'=>$livreurs->getMail()]
                        ),
                        'text/html'
                    );
                $status = $mailer->send($message);
            }
            return $this->redirectToRoute('frontacc');
        }
        return $this->render('back/livreurs.html.twig',
            [
                'form'=>$form->createView(), 'liv'=>$en
            ]
        );
    }

    /**
     * @param Request $request
     * @Route("/Modifierlivreurs/{id}",name="modifierlivreurs")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(LivreursRepository $repository,$id,Request $request)
    {
        $livreurs=$repository->find($id);
        $form=$this->createForm(LivreursType::class,$livreurs);
        $en=$this->getDoctrine()->getManager()->getRepository(Livreurs::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('ajouterlivreurs');
        }
        return $this->render('back/livreurs.html.twig',
            [
                'form'=>$form->createView(), 'liv'=>$en
            ]
        );
    }
}
