<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitsRepository ;
use Symfony\Component\HttpFoundation\Session\SessionInterface ;
use App\Entity\Produits;
use App\Entity\Commande ;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PanierController extends AbstractController
{
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
    /**
     * @Route("/pay",name="payement")
     */
    public function payement(Request $request) : Response{
        if ($request->isMethod('POST')) {
            $stripe = new \Stripe\StripeClient(
                'sk_test_51IXl9nAyyifkJ2GTw02VQPccPVPzbU7UW382UezlP4Npm0ajBpy9eJMhiFk3PHdfvO7Co06fR2dzmXlqMei3CqPC00ZksblkBB'
            );
            $stripe->charges->create([
                'amount' => $request->get('amount')*0.3,
                'currency' => 'eur',
                'source' => $request->request->get('stripeToken'),
                'description' => 'My First Test Charge (created for API docs)',
            ]);
        }
        return $this->render('front/payement.html.twig');

    }
    /**
     * @Route("/panier", name="panier")
     */

    public function panier(Request $request, ProduitsRepository $pr): Response
    {
        //  $this->session->set('Pid', [1,2]);
        $pids = $this->session->get('Pid', []);
        $produits = $pr->findBy(['id' => $pids]);
        $total = 0;
        foreach ($produits as $produit) {
            $total += $produit->getPrix();
        }
        return $this->render('front/panier.html.twig', ['produits' => $produits, 'total' => $total]);
    }
    /**
     * @Route("/ajoutpanier/{id}", name="panieraj")
     */
    public function ajoutpanier($id): Response
    {
        $produits = $this->session->get('Pid', []);
        $produits = \array_diff($produits, [$id]);
        $produits[]=$id ;
        $this->session->set('Pid', $produits);
        return $this->json(['code' => 200, 'pid' => $produits], 200);
    }
    /**
     * @Route("/erreur", name="erreur")
     */
    public function erreur(Request $request): Response
    {
        $er =   $request->get('er');
        return $this->render('front/erreur.html.twig', ['erreur' => $er]);
    }
        /**
     * @Route("/panierdel/{id}", name="panierdel")
     */
    public function deleteprod($id): Response
    {

        try {
            $produits = $this->session->get('Pid', []);
            $produits = \array_diff($produits, [$id]);
            $this->session->set('Pid', $produits);
        } catch (\Exception $e) {
            return $this->json(['code' => 500, 'Exception' => $e], 500);
        }
        return $this->json(['code' => 200, 'pid' => $produits], 200);
    }

    /**
     * @Route ("/ajoutcom", name="ajoutcom")
     */
    public function ajoutcom(ProduitsRepository $produitRepository, Request $request): Response
    {$total = 0 ;
        $user = $this->getUser();
    if ($user) {
        if ($user->isVerified()) {
            $idP = $this->session->get('Pid', []);
            $parametersAsArray = [];
            if ($content = $request->getContent()) {
                $parametersAsArray = json_decode($content, true);
            }
            if ($idP != []) {
                $i = 0;
                $Utilisateur = $this->getUser();
                $produits = $produitRepository->findBy(['id' => $idP]);
                foreach ($produits as $prod) {
                    if ($prod->getQuantite()>= $parametersAsArray['qty'][$i] ) {
                        $prod->setQuantite($prod->getQuantite()- $parametersAsArray['qty'][$i]);
                        $Commande = new Commande();
                        $Commande->setDateCommande(new \DateTime());
                        $Commande->setUtilisateur($Utilisateur);
                        $Commande->setProduit($prod);
                        $Commande->setQuantite($parametersAsArray['qty'][$i]);
                        $Commande->setPrix($prod->getPrix() * $parametersAsArray['qty'][$i]);
                        $total += ($prod->getPrix() * $parametersAsArray['qty'][$i]);
                        $en = $this->getDoctrine()->getManager();
                        $en->persist($Commande);
                        $en->flush();
                        $i = $i + 1;
                    }else {
                        return $this->json(['code' => 200, 'link' => "http://127.0.0.1:8000/erreur?er=cette quantite n'existe pas"], 200);
                    }
                }
                $this->session->set('Pid', []);
                return $this->json(['code' => 200, 'link' => "http://127.0.0.1:8000/pay?amount=".strval($total)], 200);
            }
            return $this->json(['code' => 200, 'link' => "http://127.0.0.1:8000/panier"], 200);
        } else {
            return $this->json(['code' => 200, 'link' => "http://127.0.0.1:8000/erreur?er=verfier votre compte par mail stp"], 200);
        }
    }else {
        return $this->json(['code' => 200, 'link' => "http://127.0.0.1:8000/loginf"], 200);
    }
}
}
