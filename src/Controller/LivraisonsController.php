<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivraisonsController extends AbstractController
{
    /**
     * @Route("/livraisons", name="livraisons")
     */
    public function index(): Response
    {
        return $this->render('livraisons/acceuil.htmltwig', [
            'controller_name' => 'LivraisonsController',
        ]);
    }
}
