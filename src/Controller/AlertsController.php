<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlertsController extends AbstractController
{
    /**
     * @Route("/alerts", name="alerts")
     */
    public function index(): Response
    {
        return $this->render('alerts/acceuil.html.twig.twig', [
            'controller_name' => 'AlertsController',
        ]);
    }
}
