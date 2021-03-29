<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Postlike;
use App\Entity\Produits;
use App\Entity\Publicite;
use App\Form\ProduitsType;
use App\Repository\PostlikeRepository;
use App\Repository\ProduitsRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Knp\Component\Pager\PaginatorInterface;

class ProduitsController extends AbstractController
{    private $up ;

    /**
     * @Route("/produitsolo", name="produitsolos")
     */
    public function produitsolo(Request $request)
    {
        $id =   $request->get('id');
        $pubicite=$this->getDoctrine()->getManager()->getRepository(Publicite::class)->findAll();
        $cas=$this->getDoctrine()->getManager()->getRepository(Categories::class)->findAll();
        $en=$this->getDoctrine()->getManager()->getRepository(Produits::class)->findAll();

        $ca=$this->getDoctrine()->getManager()->getRepository(Produits::class)->findBy(['id'=>$id]);
        return $this->render('front/produitsolo.html.twig', [
            'prod' => $ca,'pubicite' => $pubicite,'cat'=>$cas,'prods' => $en
        ]);
    }



    /**
     * @Route("/produitf", name="frontproduitss")
     */
    public function produi(Request $request,PaginatorInterface $paginator)
    {
        $id =   $request->get('id');
        $cas=$this->getDoctrine()->getManager()->getRepository(Categories::class)->findAll();
        $pubicite=$this->getDoctrine()->getManager()->getRepository(Publicite::class)->findAll();


        if ($id){
        $ca=$this->getDoctrine()->getManager()->getRepository(Categories::class)->findBy(['id'=>$id]);
            $produits=$this->getDoctrine()->getManager()->getRepository(Produits::class)->findBy(['categorie'=>$ca]);
            $en=$paginator->paginate(
                $produits,
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                4);
            }
        else {
            $produits=$this->getDoctrine()->getRepository(Produits::class)->findBy([],['nom' => 'desc']);
            $en=$paginator->paginate(
                $produits,
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                8
            );

        }

        return $this->render('front/prod.html.twig', [             'prod' => $en,'cat'=>$cas,'pubicite' => $pubicite        ]);
    }

    /**
     * @Route ("/post/{id}/like",name="post_like")
     * @param Produits $produits
     * @param PostlikeRepository $likerepo
     *
     * @return Response
     */
    public function like (Produits $produits,PostlikeRepository $likerepo,EntityManagerInterface $entityManager):Response
    { $user=$this->getUser();
        if(!$user) return $this->json([
            'code'=> 403,
            'message'=> "unsuthorised"
        ],403);

        if($produits->islikedByUser($user)){
            $like=$likerepo->findOneBy([
                'post'=>$produits,
                'user'=>$user
            ]);
            $entityManager->remove($like);
            $entityManager->flush();
            return $this->json(
                [
                    'code'=> 200,
                    'message'=>'like bien supprime',
                    'likes'=>$likerepo->count(['post'=>$produits])
                ],200

            );
        }
        $like =new Postlike();
        $like->setPost($produits)
            ->setUser($user);
        $entityManager->persist($like);
        $entityManager->flush();




        return $this->json(['code'=> 200, 'message'=>'clike bien ajoute','likes'=>$likerepo->count(['post'=>$produits])],200);

    }

    /**
     * @Route("/produitindex", name="produitindex")
     */
    public function index(): Response
    {
        return $this->render('back/produits.html.twig', [
            'controller_name' => 'ProduitsController',
        ]);
    }


    /**
     * @Route("/SupprimerProduits/{id}",name="deleteproduits")
     */
    function Delete($id,ProduitsRepository $repository)
    {
        $produits=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($produits);
        $em->flush();//mise a jour
        return $this->redirectToRoute('ajouterproduitsa');
    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/produit",name="ajouterproduitsa")
     */
    function Add(Request $request,\Swift_Mailer $mailer)
    {
        $produits=new Produits();
        $user=$this->getUser();
        $form=$this->createForm(ProduitsType::class,$produits);
        $en=$this->getDoctrine()->getManager()->getRepository(Produits::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($produits);
            $message = (new \Swift_Message('Alerte!'))
                ->setFrom('HYTACOCAMPII@gmail.com')
                ->setTo($produits->getUtilisateur()->getEmail())
                ->setBody(
                    'Par cet email présent nous vous promosons ces numéros pour vous aider: 
                193          : Garde nationale.
                197          : Police nationale.
                198          : Protection civile.
                801111      : numéro vert.
                ,'
                );
            $mailer->send($message);
            $em->flush();
            return $this->redirectToRoute('ajouterproduitsa');
        }
        return $this->render('back/produits.html.twig',
            [
                'form'=>$form->createView(),'prod'=>$en, 'us'=>$user ,'uss'=>$user
            ]
        );
    }



    /**
     * @param Request $request
     * @Route("/ModifierProduits/{id}",name="modifierproduits")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(ProduitsRepository $repository,$id,Request $request)
    {
        $user=$this->getUser();
        $produits=$repository->find($id);
        $form=$this->createForm(ProduitsType::class,$produits);
        $en=$this->getDoctrine()->getManager()->getRepository(Produits::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('ajouterproduitsa');
        }
        return $this->render('back/produits.html.twig',
            ['form'=>$form->createView(), 'prod'=>$en, 'uss'=>$user]);
    }

}
