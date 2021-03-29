<?php

namespace App\Controller;

use App\Entity\Evenements;
use App\Form\EvenementsType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\RepositoryFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\EvenementsRepository;

class EvenementsController extends AbstractController
{
    /**
     * @Route("/evenements", name="evenements")
     */
    public function index(): Response
    {
        return $this->render('evenements/acceuil.htmltwig', [
            'controller_name' => 'EvenementsController',
        ]);
    }


    /**
     * @param EvenementsRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/evenementf", name="affiche")
     */
    public function Affichage(EvenementsRepository $repository)
    {
        //$en=$this->getDoctrine()->getManager()->getRepository(Evenements::class)->findAll();
        // var_dump($en);
        $en = $repository->findAll();
        return $this->render('front/evenements.html.twig ',
            ['event' => $en]);
    }

    /**
     * @Route("/supprimer{id}", name="supprimer")
     */
    public function supprimer(Evenements $event, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($event);
        $entityManager->flush();
        return $this->redirectToRoute('evenements');
    }


    /**
     * @Route("/evenement", name="evenements")
     */
    public function AjouterEvenement(Request $request)
    {
        $user = $this->getUser();
        $en = $this->getDoctrine()->getManager()->getRepository(Evenements::class)->findAll();
        $evenement = new Evenements();
        $form = $this->createForm(EvenementsType::class, $evenement);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('evenements');
        }
        return $this->render('back/evenements.html.twig', ['form' => $form->createView(), 'formations' => $en, 'us' => $user
        ]);
    }



    /**
     * @param Request $request
     * @Route("/ModifierEvenements/{id}",name="modifierevenement")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(EvenementsRepository $repository,$id,Request $request)
    {
        $user = $this->getUser();
        $sponsors = $repository->find($id);
        $form = $this->createForm(EvenementsType::class, $sponsors);
        $en = $this->getDoctrine()->getManager()->getRepository(Evenements::class)->findAll();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('evenements');
        }
        return $this->render('back/evenements.html.twig',
            [
                'form' => $form->createView(), 'formations' => $en, 'us' => $user
            ]
        );

    }


}