<?php

namespace App\Controller;

use App\Entity\Sponsors;
use App\Form\SponsorsType;
use App\Repository\SponsorsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;


class SponsorsController extends AbstractController
{
    /**
     * @Route("/sponsors", name="sponsors")
     */
    public function index(): Response
    {
        return $this->render('sponsors/acceuil.htmltwig', [
            'controller_name' => 'SponsorsController',
        ]);
    }

    /**
     * @param SponsorsRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/afficher", name="afficher")
     */
    public function afficher(SponsorsRepository $repository)
    {
        //$en=$this->getDoctrine()->getManager()->getRepository(Evenements::class)->findAll();
        // var_dump($en);
        $en = $repository->findAll();
        return $this->render('front/acceuil.html.twig ',
            ['sponsor' => $en]);
    }



    /**
     * @Route("/suppression{id}", name="suppression")
     */
    public function supprimerSponsor (Sponsors $sponsors,  EntityManagerInterface $entityManager){
        $entityManager->remove($sponsors);
        $entityManager->flush();
        $this->addFlash(
            'info',
            'Deleted successfuly'
        );
        return $this->redirectToRoute('ajoutsponsors');
    }

    /**
     * @Route("/sponsor", name="ajoutsponsors")
     */
    public function Ajouter(Request $request,\Swift_Mailer $mailer)
    {
        $user=$this->getUser();
        $en=$this->getDoctrine()->getManager()->getRepository(Sponsors::class)->findAll();
        $sponsors=new Sponsors();
        //  $sponsors->getEvenements($this->getUser());
        $form=$this->createForm(SponsorsType::class , $sponsors);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($sponsors);
            $message = (new \Swift_Message('Mail de confirmation'))
                ->setFrom('HYTACOCAMPII@gmail.com')->setTo($sponsors->getMail())->setBody(
                    'Par cet email présent nous vous informons que vous etes officiellement notre sponsor.Merci'
                );
            $mailer->send($message);
            $em->flush();
            $this->addFlash(
                'info',
                'Added successfuly'
            );
            return $this->redirectToRoute('ajoutsponsors');
        }
        return $this->render('back/sponsors.html.twig', ['form'=>$form->createView(),'formations'=>$en, 'us'=>$user
        ]);
    }

    /**
     * @param Request $request
     * @Route("/ModifierSponsors/{id}",name="modifiersponsors")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(SponsorsRepository $repository,$id,Request $request)
    {
        $user=$this->getUser();
        $sponsors=$repository->find($id);
        $form=$this->createForm(SponsorsType::class,$sponsors);
        $en=$this->getDoctrine()->getManager()->getRepository(Sponsors::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash(
                'info',
                'Edited successfuly'
            );
            return $this->redirectToRoute('ajoutsponsors');
        }
        return $this->render('back/sponsors.html.twig',
            [
                'form'=>$form->createView(), 'formations'=>$en, 'us'=>$user
            ]
        );
    }



}
