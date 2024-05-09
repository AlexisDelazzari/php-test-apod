<?php

namespace App\Services;

use App\Entity\Picture;
use App\Repository\PictureRepository;
use Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PictureService
{
    private HttpClientInterface $client;
    private PictureRepository $PictureRepository;

    public function __construct(
        HttpClientInterface $client,
        PictureRepository $PictureRepository
    ) {
        $this->client = $client;
        $this->PictureRepository = $PictureRepository;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function getPictureOfTheDay(): array
    {
        try {
            $response = $this->client->request('GET', 'https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY');
            return $response->toArray();
        } catch (Exception $e) {
            throw new Exception('An error occurred while fetching the picture of the day');
        }
    }

    /**
     * @throws Exception
     */
    public function savePicture(array $pictureData): void
    {
        $picture = new Picture();
        $picture->setDate(new \DateTime($pictureData['date']));
        $picture->setUrl($pictureData['url']);
        $picture->setTitle($pictureData['title']);
        $picture->setExplanation($pictureData['explanation']);
        $picture->setMediaType($pictureData['media_type']);

        $this->PictureRepository->save($picture);
    }

    public function getPictureByDate(\DateTime $date): Picture | null
    {
        $picture = $this->PictureRepository->findOneBy(['date' => $date, 'media_type' => 'image']);

        if (!$picture) {
            $picture = $this->PictureRepository->findPreviousImage($date);
        }

        return $picture;
    }

    public function isLiked(Picture $picture, $user): bool
    {
        return $picture->getLikes()->exists(function ($key, $like) use ($user) {
            return $like->getUser() === $user;
        });
    }

    public function getNbLikes(Picture $picture): int
    {
        return $picture->getLikes()->count();
    }
}