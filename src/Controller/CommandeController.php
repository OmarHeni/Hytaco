<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commandes", name="commande")
     */
    public function index(CommandeRepository $cr): Response
    {
        $user=$this->getUser();
        $coms =  $cr->findAll();
        return $this->render('back/commandes.html.twig', [
            'commandes' => $coms,'us'=>$user
        ]);
    }
    /**
     * @Route("/commandesf", name="commandef")
     */
    public function affichecom(CommandeRepository $cr): Response
    {
        $user = $this->getUser();
        $coms =  $cr->findBy(['utilisateur'=>$user]);
        return $this->render('front/commandesf.html.twig', [
            'commandes' => $coms,
        ]);
    }
    /**
     * @Route("/commandesmof", name="commandemof")
     */
    public function commof(CommandeRepository $cr,Request $request): Response
    {try{
        if ($content = $request->getContent()) {
            $json = json_decode($content, true);
        }
$com = $cr->find($json['id']);
      $com->setPrix(($com->getPrix()/$com->getQuantite())*$json['qty']);
        $com->setQuantite($json['qty']);

        $this->getDoctrine()->getManager()->flush();
        return $this->json(['id'=>$json['id']],200);
    } catch (\Exception $e) {
return $this->json(['code' => 500, 'Exception' => $e], 500);
}
     /*   $coms =  $cr->find($id);
        return $this->render('back/commandes.html.twig', [
            'commandes' => $coms,
        ]);*/
    }
    /**
     * @Route("/delcom/{id}", name="delcom")
     */
    public function delcom(CommandeRepository $cr,$id): Response
    {
        $com = $cr->findOneBy(array('id'=>$id));
        $em = $this->getDoctrine()->getManager();
       $em->remove($com);
        $em->flush();
        return $this->redirect('/commandes');
    }
    /**
     * @Route("/delcomf/{id}", name="delcomf")
     */
    public function delcomf(CommandeRepository $cr,$id): Response
    {
        $com = $cr->findOneBy(array('id'=>$id));
        $em = $this->getDoctrine()->getManager();
        $em->remove($com);
        $em->flush();
        return $this->redirect('/commandesf');
    }

}
