<?php

namespace App\Controller;
use App\Repository\UtilisateurRepository;
use App\Security\EmailVerifier;
use App\Entity\Utilisateur;
use App\Form\AddUtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;

class UtilisateurController extends AbstractController
{
    private $em ;
    private $up ;
    public function __construct(UtilisateurRepository $up,EntityManagerInterface $em)
    {
        $this->up = $up;
        $this->em = $em ;
    }

    /**
     * @Route("/inscription", name="utilisateur_front")
     */
    public function inscription(Request $request,UserPasswordEncoderInterface $encoder,\Swift_Mailer $mailer): Response
    {
        $user = new Utilisateur();
        $form= $this->createForm(AddUtilisateurType::class, $user);
        $user->getRoles(['ROLE_USER']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirect("/accueil");
        }
        else {
            return $this->render('front/compte.html.twig',
                ['form'=>$form->Createview()]);
        }
    }
    /**
     * @Route("/utilisateur", name="utilisateur_back")
     */
    public function utilisateur (Request $request,UserPasswordEncoderInterface $encoder,\Swift_Mailer $mailer): Response
    {   $session =  $request->getSession()->get('email');
        $us = $this->up->findOneBy(array('email'=>$session),array());

        $user = new Utilisateur();
        $user->setActivationToken(md5(uniqid()));
        $users = $this->up->findAll();
        $form= $this->createForm(AddUtilisateurType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
           $this->em->persist($user);
           $this->em->flush();
          $message = (new \Swift_Message('Activation de votre compte'))
                ->setFrom('elheniomar@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView('front/activation.html.twig',['token'=>$user->getActivationToken()]
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);
            return $this->redirect("/blog");
        }
        else {
            return $this->render('back/utilisateurs.html.twig',
                ['form'=>$form->Createview(),'users'=>$users,'us'=>$us]);
        }

        //  $form = $this->createForm(UtilisateurAddType::class,$user)
    }
    /**
     * @Route("/delete_user/{id}", name="del_user")
     */
public function delete_user($id): Response
{
    $user = $this->up->findOneBy(array('id'=>$id));
    $this->em->remove($user);
    $this->em->flush();
    return $this->redirect('/utilisateur');
}
/**
 * @IsGranted("ROLE_ADMIN")
 * @Route ("/Edit_user/{id}",name="edit_user")
 */
public function Edit_user($id,Request $request,UserPasswordEncoderInterface $encoder){
    $user = $this->up->findOneBy(array('id'=>$id));
     $form= $this->createForm(AddUtilisateurType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
           $this->em->persist($user);
           $this->em->flush();
            return $this->redirect("/utilisateur");
        }
return $this->render('back/profile.html.twig',
    ['form'=>$form->Createview()]);
}

/**
 * @Route("/activation/{token}",name="activation")
 */
public function activation ($token, UtilisateurRepository $up){
    $user=  $up->findOneBy(['activationToken'=>$token]);
    if($user) {
        $user->setActivationToken(null);
        $en = $this->getDoctrine()->getManager();
        $en->persist($user);
        $en->flush();
    }
    return $this->redirect('frontacc');
  /*  $en=$this->getDoctrine()->getManager();
    $en->persist($user);
    $en->flush();
    $this->addFlash('message','vous avez activé votre compte');
return $this->redirect('accueil');*/
}
}
