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
     * @Route("/suppression{id}", name="suppression")
     */
    public function supprimerSponsor (Sponsors $sponsors,  EntityManagerInterface $entityManager){
        $entityManager->remove($sponsors);
        $entityManager->flush();
        return $this->redirectToRoute('ajoutsponsors');
    }

    /**
     * @Route("/sponsor", name="ajoutsponsors")
     */
    public function Ajouter(Request $request)
    {
        $en=$this->getDoctrine()->getManager()->getRepository(Sponsors::class)->findAll();
        $sponsors=new Sponsors();
        $form=$this->createForm(SponsorsType::class , $sponsors);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($sponsors);
            $em->flush();
            return $this->redirectToRoute('ajoutsponsors');
        }
        return $this->render('back/sponsors.html.twig', ['form'=>$form->createView(),'formations'=>$en
        ]);
    }

    /**
     * @param Request $request
     * @Route("/ModifierSponsors/{id}",name="modifiersponsors")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(SponsorsRepository $repository,$id,Request $request)
    {
        $sponsors=$repository->find($id);
        $form=$this->createForm(SponsorsType::class,$sponsors);
        $en=$this->getDoctrine()->getManager()->getRepository(Sponsors::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('ajoutsponsors');
        }
        return $this->render('back/sponsors.html.twig',
            [
                'form'=>$form->createView(), 'formations'=>$en
            ]
        );
    }



}
