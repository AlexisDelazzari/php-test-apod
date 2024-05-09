<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\PictureLiked;
use App\Repository\PictureLikedRepository;
use App\Repository\PictureRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends AbstractController
{
    private PictureRepository $PictureRepository;
    private PictureLikedRepository $PictureLikedRepository;
    private UserRepository $UserRepository;

    public function __construct(PictureRepository $PictureRepository, PictureLikedRepository $PictureLikedRepository, UserRepository $UserRepository)
    {
        $this->PictureRepository = $PictureRepository;
        $this->PictureLikedRepository = $PictureLikedRepository;
        $this->UserRepository = $UserRepository;
    }

    #[Route('/picture', name: 'app_picture')]
    public function index(): Response
    {
        return $this->render('picture/index.html.twig', [
            'controller_name' => 'PictureController',
        ]);
    }

    //like or dislike a picture by id
    #[Route('/picture/like/{id}', name: 'app_picture_like')]
    public function like(int $id, PictureLikedRepository $PictureLikedRepository, PictureRepository $PictureRepository, UserRepository $UserRepository): Response
    {

        $picture = $this->PictureRepository->find($id);
        if (!$picture) {
            $this->addFlash('error', 'Photo non trouvée');
            return $this->redirectToRoute('app_home');
        }

        $like = $this->PictureLikedRepository->findOneBy(['picture' => $picture, 'user' => $this->getUser()]);

        if ($like) {
            $this->PictureLikedRepository->remove($like);
            $this->addFlash('success', 'Photo retirée des favoris');
        } else {
            $like = new PictureLiked();
            $like->setPicture($picture);
            $like->setUser($this->UserRepository->find($this->getUser()->getId()));
            $this->PictureLikedRepository->like($like);
            $this->addFlash('success', 'Photo ajoutée aux favoris');
        }

        return $this->redirectToRoute('app_home');

    }
}
