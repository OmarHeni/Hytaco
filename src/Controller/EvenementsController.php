<?php

namespace App\Controller;

use App\Entity\Evenements;
use App\Entity\PostLikes;
use App\Entity\Sponsors;
use App\Form\EvenementsType;
use App\Repository\PostLikesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\RepositoryFactory;
use Doctrine\Persistence\ObjectManager;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\EvenementsRepository;
use Symfony\Contracts\Translation\TranslatorInterface;
use Dompdf\Options;

class EvenementsController extends AbstractController
{
    /**
     * @Route("/evenements", name="evenements")
     */
    public function index(): Response
    {
        return $this->render('evenements/acceuil.htmltwig', [
            'controller_name' => 'EvenementsController',
        ]);
    }

    /**
     * @param EvenementsRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/listp", name="listp")
     */
    public function Affichagep(EvenementsRepository $repository)
    {
        //$en=$this->getDoctrine()->getManager()->getRepository(Evenements::class)->findAll();
        // var_dump($en);
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $en = $repository->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('back/listp.html.twig ',
            ['formations' => $en]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);

    }


    /**
     * @param EvenementsRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/evenementf", name="affiche")
     */
    public function Affichage(EvenementsRepository $repository)
    {
        $sp=$this->getDoctrine()->getManager()->getRepository(Sponsors::class)->findAll();

        //$en=$this->getDoctrine()->getManager()->getRepository(Evenements::class)->findAll();
        // var_dump($en);
        $en = $repository->findAll();
        return $this->render('front/evenements.html.twig ',
            ['events' => $en,'sponsor' => $sp]);
    }

    /**
     * @Route("/supprimer{id}", name="supprimer")
     */
    public function supprimer(Evenements $event, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($event);
        $entityManager->flush();
        $this->addFlash(
            'info',
            'Deleted successfuly'
        );
        return $this->redirectToRoute('evenements');
    }


    /**
     * @Route("/evenement", name="evenements")
     */
    public function AjouterEvenement(Request $request)
    {
        $user = $this->getUser();
        $en = $this->getDoctrine()->getManager()->getRepository(Evenements::class)->findAll();
        $evenement = new Evenements();
        $form = $this->createForm(EvenementsType::class, $evenement);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            $this->addFlash(
                'info',
                'Added successfuly'
            );
            return $this->redirectToRoute('evenements');
        }
        return $this->render('back/evenements.html.twig', ['form' => $form->createView(), 'formations' => $en, 'us' => $user
        ]);
    }



    /**
     * @param Request $request
     * @Route("/ModifierEvenements/{id}",name="modifierevenement")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(EvenementsRepository $repository,$id,Request $request,TranslatorInterface $translator)
    {
        $user = $this->getUser();
        $sponsors = $repository->find($id);
        $form = $this->createForm(EvenementsType::class, $sponsors);
        $en = $this->getDoctrine()->getManager()->getRepository(Evenements::class)->findAll();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $message = $translator->trans('Event modified successfuly');
            $this->addFlash('message',$message);
            return $this->redirectToRoute('evenements');
        }
        return $this->render('back/evenements.html.twig',
            [
                'form' => $form->createView(), 'formations' => $en, 'us' => $user
            ]
        );

    }

    /**
     * @Route("/post/{id}/like", name="post_likess")
     * @param Evenements $post
     * @param EntityManagerInterface $entityManager
     * @param PostLikeRepository $likeRepo
     * @return Response
     */
    public function like(Evenements $post,EntityManagerInterface $entityManager,PostLikesRepository $likeRepo):Response{


        $user = $this->getUser();
        if (!$user) {
            return $this->json(['code' => 403, 'message' => 'Vous devez être connecté !'], 403);
        }

        if ($post->isLikedByUser($user)) {
            $like = $likeRepo->findOneBy(['post' => $post, 'user' => $user]);
            $entityManager->remove($like);
            $entityManager->flush();
            return $this->json(['code' => 200,'message' =>'Like supprime', 'likes' => $likeRepo->count(['post'=> $post])], 200);
        }
        $like = new PostLikes();
        $like->setPost($post)
            ->setUser($user);

        $entityManager->persist($like);
        $entityManager->flush();

        return $this->json(['code' =>200,'message' =>'Like bien ajoute',
            'likes' => $likeRepo->count(['post'=> $post])
        ],200);
    }




}