<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\GithubClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route ;
use Symfony\Component\HttpFoundation\Request ;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Security2Controller extends AbstractController
{
    /**
     * @Route("/loginf", name="app_loginf")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('front/loginf.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    /**
     * @Route("/loginf/github", name="loginf_github")
     */
    public function logingit(ClientRegistry $clientRegistry): RedirectResponse
    {
        /** @var GithubClient $client */
        $client = $clientRegistry->getClient('github');
        return $client->redirect(['read:user','user:email']);

    }

    /**
     * @Route("/logoutf", name="app_logoutf")
     */
    public function logout(UrlGeneratorInterface $urlGenerator,TokenStorageInterface $tokenStorage)
    {
        $tokenStorage->setToken();

        return new RedirectResponse($urlGenerator->generate("app_loginf"));
    }
}
