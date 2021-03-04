<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
