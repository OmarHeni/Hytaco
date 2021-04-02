<?php

namespace App\Controller;

use App\Entity\Coupon;
use App\Form\CouponType;
use App\Repository\CommandeRepository;
use App\Repository\CouponRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class CommandeController extends AbstractController
{
    /**
     * @Route("/affcommandes", name="commandeaffs")
     */

    public function affcoms(CommandeRepository $cr): Response
    {
        $i = 0;
        $array= [];
        $array2=[];
        $stats = $cr->findAllPerDate();

        foreach ($stats as $com) {

            foreach ($com as $coma) {
                if($coma instanceof \DateTime){
                    $array[]=$coma->format('d-m-Y');
                }else {
                    $array[] = $coma;
                }
            }

            $array2[]=$array;
            $array=[];
        }
        return $this->json($array2);


    }
    /**
     * @Route("/commandes", name="commande")
     */
    public function index(CommandeRepository $cr): Response
    {
        $coms =  $cr->findAll();
        $us = $this->getUser();
        return $this->render('back/commandes.html.twig', [
            'commandes' => $coms,'us'=>$us
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
    /**
     * @Route("/delcoupon/{id}",name="delcoupon")
     */
    function Delete($id,CouponRepository $repository)
    {
        $coupon=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($coupon);
        $em->flush();//mise a jour
        return $this->redirectToRoute('affcoupon');
    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/affcoupon",name="affcoupon")
     */
    function Addcoupon(Request $request)
    {
        $coupon =new Coupon();
        $form=$this->createForm(CouponType::class, $coupon);
        $en=$this->getDoctrine()->getManager()->getRepository(Coupon::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($coupon);
            $em->flush();
            return $this->redirectToRoute('affcoupon');
        }
        return $this->render('back/coupon.html.twig',
            [
                'form'=>$form->createView(), 'coupons'=>$en
            ]
        );
    }


    /**
     * @param Request $request
     * @Route("/mofcoupon/{id}",name="mofcoupon")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(CouponRepository $repository,$id,Request $request)
    {
        $coupon=$repository->find($id);
        $form=$this->createForm(CouponType::class,$coupon);
        $en=$this->getDoctrine()->getManager()->getRepository(Coupon::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('affcoupon');
        }
        return $this->render('back/coupon.html.twig',
            [
                'form'=>$form->createView(), 'coupons'=>$en
            ]
        );
    }
}
