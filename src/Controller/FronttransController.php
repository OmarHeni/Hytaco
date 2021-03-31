<?php

namespace App\Controller;

use App\Entity\Transporteur;
use App\Form\TransporteurType;
use App\Repository\TransporteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;

class FronttransController extends AbstractController
{
    /**
     * @Route("/fronttrans", name="fronttrans")
     */
    public function index(): Response
    {
        return $this->render('consult/index.html.twig', [
            'controller_name' => 'FronttransController',
        ]);
    }
    /**

     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/fronttransds",name="transaffiched")
     */
    function affiche()
    {
        $en=$this->getDoctrine()->getManager()->getRepository(Transporteur::class)->findAll();
return $this->render('front/consult.html.twig',
[
'trans'=>$en
]
);}
}
