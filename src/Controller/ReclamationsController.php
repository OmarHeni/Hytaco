<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReclamationsController extends AbstractController
{
    /**
     * @Route("/reclamations", name="reclamations")
     */
    public function index(): Response
    {
        return $this->render('reclamations/acceuil.htmltwig', [
            'controller_name' => 'ReclamationsController',
        ]);
    }
}
