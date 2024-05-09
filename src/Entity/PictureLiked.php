<?php

namespace App\Entity;

use App\Repository\PictureLikedRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PictureLikedRepository::class)]
class PictureLiked
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Picture::class)]
    private Picture $picture;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $likedAt;

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): PictureLiked
    {
        $this->user = $user;
        return $this;
    }

    public function getPicture(): Picture
    {
        return $this->picture;
    }

    public function setPicture(Picture $picture): PictureLiked
    {
        $this->picture = $picture;
        return $this;
    }

    public function getLikedAt(): \DateTimeInterface
    {
        return $this->likedAt;
    }

    public function setLikedAt(\DateTimeInterface $likedAt): PictureLiked
    {
        $this->likedAt = $likedAt;
        return $this;
    }

    public function __construct()
    {
        $this->likedAt = new \DateTime();
    }
}
