<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgrammesController extends AbstractController
{
    /**
     * @Route("/programmes", name="programmes")
     */
    public function index(): Response
    {
        return $this->render('programmes/acceuil.htmltwig', [
            'controller_name' => 'ProgrammesController',
        ]);
    }
}
