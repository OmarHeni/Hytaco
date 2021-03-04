<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontaccController extends AbstractController
{
    /**
     * @Route("/frontacc", name="frontacc")
     */
    public function index(): Response
    {
        return $this->render('frontacc/index.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }
}
