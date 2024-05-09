<?php

namespace App\Controller;

use App\Repository\PictureRepository;
use App\Services\PictureService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private PictureService $PictureService;
    private PictureRepository $PictureRepository;

    public function __construct(PictureService $PictureService, PictureRepository $PictureRepository)
    {
        $this->PictureService = $PictureService;
        $this->PictureRepository = $PictureRepository;
    }

    #[Route('/home', name: 'app_home')]
    public function index(PictureService $PictureService, PictureRepository $PictureRepository): Response
    {
        $type_message = $_GET['type_message'] ?? null;
        $message = $_GET['message'] ?? null;

        if ($type_message && $message) {
            $this->addFlash($type_message, $message);
        }

        if (!$this->getUser()) {
            return $this->render('home/index.html.twig');
        }

        $picture = $this->PictureRepository->findOneBy(['date' => new \DateTime()]);

        if (!$picture) {
            $picture = $this->PictureService->getPictureByDate(new \DateTime());
            $message_error = $picture ? null : 'Aucune photo trouvée. Veuillez réessayer plus tard.';
        } elseif ($picture->getMediaType() === 'video') {
            $picture = $this->PictureService->getPictureByDate(new \DateTime());

            $message_error = $picture && $picture->getMediaType() === 'image' ?
                'Malheureusement, la photo du jour est une vidéo. Voici la dernière photo disponible.' :
                'Malheureusement, la photo du jour est une vidéo. Nous ne pouvons pas l\'afficher.';
        }

        return $this->render('home/index.html.twig', [
            'picture' => $picture,
            'message' => $message_error ?? null,
            'liked' => $this->PictureService->isLiked($picture, $this->getUser()),
            'nbLikes' => $this->PictureService->getNbLikes($picture),
        ]);
    }

}
