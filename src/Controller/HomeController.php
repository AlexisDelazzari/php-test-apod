<?php

namespace App\Controller;

use App\Repository\PictureRepository;
use App\Services\PictureService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private PictureService $pictureService;
    private PictureRepository $pictureRepository;

    public function __construct(PictureService $pictureService, PictureRepository $pictureRepository)
    {
        $this->pictureService = $pictureService;
        $this->pictureRepository = $pictureRepository;
    }

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        $typeMessage = $_GET['type_message'] ?? null;
        $message = $_GET['message'] ?? null;

        if ($typeMessage && $message) {
            $this->addFlash($typeMessage, $message);
        }

        if (!$this->getUser()) {
            return $this->render('home/index.html.twig');
        }

        $picture = $this->pictureRepository->findOneBy(['date' => new \DateTime()]);

        if (!$picture) {
            $picture = $this->pictureService->getPictureByDate(new \DateTime());
            $messageError = $picture ? null : 'Aucune photo trouvée. Veuillez réessayer plus tard.';
        } elseif ($picture->getMediaType() === 'video') {
            $picture = $this->pictureService->getPictureByDate(new \DateTime());

            $messageError = $picture && $picture->getMediaType() === 'image' ?
                'Malheureusement, la photo du jour est une vidéo. Voici la dernière photo disponible.' :
                'Malheureusement, la photo du jour est une vidéo. Nous ne pouvons pas l\'afficher.';
        }

        return $this->render('home/index.html.twig', [
            'picture' => $picture,
            'message' => $messageError ?? null,
            'liked' => $picture ? $this->pictureService->isLiked($picture, $this->getUser()) : 0,
            'nbLikes' => $picture ? $this->pictureService->getNbLikes($picture) : 0,
        ]);
    }
}