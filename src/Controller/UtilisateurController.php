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

/**
 * @IsGranted("ROLE_ADMIN")
 */
class UtilisateurController extends AbstractController
{
    private $emailVerifier;
    private $em ;
    private $up ;
    public function __construct(EmailVerifier $emailVerifier,UtilisateurRepository $up,EntityManagerInterface $em)
    {
        $this->up = $up;
        $this->em = $em ;
        $this->emailVerifier = $emailVerifier;
    }


    /**
     * @Route("/utilisateur", name="utilisateur_back")
     */
    public function inscription(Request $request,UserPasswordEncoderInterface $encoder): Response
    {   $session =  $request->getSession()->get('email');
        $us = $this->up->findOneBy(array('email'=>$session),array());

        $user = new Utilisateur();
        $users = $this->up->findAll();
        $form= $this->createForm(AddUtilisateurType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
           $this->em->persist($user);
           $this->em->flush();
            return $this->redirect("/blog");
        }
        else {
            return $this->render('utilisateurs.html.twig',
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
 * @Route ("/Edit_user/{id}",name="edit_user")
 */
public function Edit_user($id,Request $request,UserPasswordEncoderInterface $encoder){
    $user = $this->up->findOneBy(array('id'=>$id));
     $form= $this->createForm(AddUtilisateurType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
           $this->em->persist($user);
           $this->em->flush();
            return $this->redirect("/utilisateur");
        }
return $this->render('profile.html.twig',
    ['form'=>$form->Createview()]);
}
}
