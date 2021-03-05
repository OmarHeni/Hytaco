<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categoriess", name="categoriess")
     */
    public function index(): Response
    {
        return $this->render('back/categories.html.twig', [
            'controller_name' => 'CategoriesController',
        ]);
    }


    /**
     * @Route("/SupprimerCategorie/{id}",name="supprimerc")
     */
    function Delete($id,CategoriesRepository $repository)
    {
        $categories=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($categories);
        $em->flush();//mise a jour
        return $this->redirectToRoute('ajoutercategories');
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/categorie",name="ajoutercategories")
     */
    function Add(Request $request)
    {
        $categories=new Categories();
        $form=$this->createForm(CategoriesType::class, $categories);
        $en=$this->getDoctrine()->getManager()->getRepository(Categories::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($categories);
            $em->flush();
            return $this->redirectToRoute('ajoutercategories');
        }
        return $this->render('back/categories.html.twig',
            [
                'form'=>$form->createView(), 'cat'=>$en
            ]
        );
    }


    /**
     * @param Request $request
     * @Route("/ModifierCategories/{id}",name="modifiercategories")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(CategoriesRepository $repository,$id,Request $request)
    {
        $categories=$repository->find($id);
        $form=$this->createForm(CategoriesType::class,$categories);
        $en=$this->getDoctrine()->getManager()->getRepository(Categories::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('ajoutercategories');
        }
        return $this->render('back/categories.html.twig',
            [
                'form'=>$form->createView(), 'cat'=>$en
            ]
        );
    }

}
