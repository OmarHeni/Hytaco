<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocauxController extends AbstractController
{
    /**
     * @Route("/locaux", name="locaux")
     */
    public function index(): Response
    {
        return $this->render('locaux/acceuil.htmltwig', [
            'controller_name' => 'LocauxController',
        ]);
    }
}
