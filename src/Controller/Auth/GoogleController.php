<?php

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;

class GoogleController extends AbstractController
{
    #[Route('/auth/google', name: 'connect_google_start')]
    public function authAction(ClientRegistry $clientRegistry): Response
    {
        return $clientRegistry
            ->getClient('google')
            ->redirect();
    }

    #[Route('/auth/google/check', name: 'connect_google_check')]
    public function connectCheckAction(): Response
    {
        return $this->redirectToRoute('app_home');
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): Response
    {
        $this->addFlash('success', 'Vous êtes déconnecté');
        return $this->render('home/index.html.twig');
    }
}
