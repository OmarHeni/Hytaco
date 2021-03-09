<?php

namespace App\Controller;

use App\Entity\Programmes;
use App\Form\ProduitsType;
use App\Form\ProgrammesType;
use App\Repository\ProduitsRepository;
use App\Repository\ProgrammesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    function Add(Request $request)
    {
        $programmes=new Programmes();
        $user=$this->getUser();
        $form=$this->createForm(ProgrammesType::class, $programmes);
        $en=$this->getDoctrine()->getManager()->getRepository(Programmes::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($programmes);
            $em->flush();
            return $this->redirectToRoute('ajouterprogrammes');
        }
        return $this->render('back/programmes.html.twig',
            [
                'form'=>$form->createView(), 'prog'=>$en , 'us'=>$user
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
                'form'=>$form->createView(), 'prog'=>$en
            ]
        );
    }



}
