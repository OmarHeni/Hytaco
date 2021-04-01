<?php

namespace App\Controller;

use App\Entity\Publicite;
use App\Form\PubliciteType;
use App\Repository\PubliciteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use  Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PubliciteController extends AbstractController
{
    /**
     * @Route("/publicitee", name="publiciteeee")
     */
    public function index(): Response
    {
        return $this->render('publicite/index.html.twig', [
            'controller_name' => 'PubliciteController',
        ]);
    }



    /**
     * @Route("/SupprimerPublicite/{id}",name="deletepublicite")
     */
    function Delete($id,PubliciteRepository $repository)
    {
        $publicite=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($publicite);
        $em->flush();//mise a jour
        return $this->redirectToRoute('ajouterpublicite');
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/publicite",name="ajouterpublicite")
     */
    function Add(Request $request)
    {
        $publicite=new Publicite();
        $user=$this->getUser();
        $form=$this->createForm(PubliciteType::class, $publicite);
        $en=$this->getDoctrine()->getManager()->getRepository(Publicite::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($publicite);
            $em->flush();
            return $this->redirectToRoute('ajouterpublicite');
        }
        return $this->render('back/publicite.html.twig',
            [
                'form'=>$form->createView(), 'pub'=>$en, 'us'=>$user
            ]
        );
    }


    /**
     * @param Request $request
     * @Route("/ModifierPublicite/{id}",name="modifierpublicite")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(PubliciteRepository $repository,$id,Request $request)
    {
        $publicite=$repository->find($id);
        $user=$this->getUser();
        $form=$this->createForm(PubliciteType::class,$publicite);
        $en=$this->getDoctrine()->getManager()->getRepository(Publicite::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('ajouterpublicite');
        }
        return $this->render('back/publicite.html.twig',
            [
                'form'=>$form->createView(), 'pub'=>$en,'uss'=>$user,'us'=>$user
            ]
        );
    }
}
