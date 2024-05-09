<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/logout_success', name: 'app_logout_success')]
    public function index(): Response
    {
        $this->addFlash('success', 'Vous êtes déconnecté');
        return $this->render('home/index.html.twig');
    }
}
