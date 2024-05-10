<?php

namespace App\Controller;

use App\Entity\PictureLiked;
use App\Repository\PictureLikedRepository;
use App\Repository\PictureRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends AbstractController
{
    private PictureRepository $pictureRepository;
    private PictureLikedRepository $pictureLikedRepository;
    private UserRepository $userRepository;

    public function __construct(PictureRepository $pictureRepository, PictureLikedRepository $pictureLikedRepository, UserRepository $userRepository)
    {
        $this->pictureRepository = $pictureRepository;
        $this->pictureLikedRepository = $pictureLikedRepository;
        $this->userRepository = $userRepository;
    }

    #[Route('/picture', name: 'app_picture')]
    public function index(): Response
    {
        return $this->render('picture/index.html.twig', [
            'controller_name' => 'PictureController',
        ]);
    }

    // Like or dislike a picture by id
    #[Route('/picture/like/{id}', name: 'app_picture_like')]
    public function like(int $id): Response
    {
        $picture = $this->pictureRepository->find($id);
        if (!$picture) {
            $this->addFlash('error', 'Photo non trouvée');
            return $this->redirectToRoute('app_home');
        }

        $like = $this->pictureLikedRepository->findOneBy(['picture' => $picture, 'user' => $this->getUser()]);

        if ($like) {
            $this->pictureLikedRepository->remove($like);
            $this->addFlash('success', 'Photo retirée des favoris');
        } else {
            $like = new PictureLiked();
            $like->setPicture($picture);
            $user = $this->getUser();
            if (!$user) {
                $this->addFlash('error', 'Utilisateur non connecté');
                return $this->redirectToRoute('app_home');
            }
            $like->setUser($this->userRepository->find($this->getUser()->getId()));
            $this->pictureLikedRepository->like($like);
            $this->addFlash('success', 'Photo ajoutée aux favoris');
        }

        return $this->redirectToRoute('app_home');
    }
}