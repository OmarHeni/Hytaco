<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
 * @IsGranted("ROLE_ADMIN")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/commandes", name="commande")
     */
    public function index(CommandeRepository $cr): Response
    {
   $coms =  $cr->findAll();
        return $this->render('commandes.html.twig', [
            'commandes' => $coms,
        ]);
    }
    /**
     * @Route("/delcom/{id}", name="delcom")
     */
    public function delcom(CommandeRepository $cr,$id): Response
    {
        $user = $cr->findOneBy(array('id'=>$id));
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirect('/commandes');
    }

}
