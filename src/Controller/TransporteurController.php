<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransporteurController extends AbstractController
{
    /**
     * @Route("/transporteur", name="transporteur")
     */
    public function index(): Response
    {
        return $this->render('transporteur/acceuil.htmltwig', [
            'controller_name' => 'TransporteurController',
        ]);
    }
}
