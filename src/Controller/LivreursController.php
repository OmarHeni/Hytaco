<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivreursController extends AbstractController
{
    /**
     * @Route("/livreurs", name="livreurs")
     */
    public function index(): Response
    {
        return $this->render('livreurs/acceuil.htmltwig', [
            'controller_name' => 'LivreursController',
        ]);
    }
}
