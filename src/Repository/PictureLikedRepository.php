<?php

namespace App\Repository;

use App\Entity\PictureLiked;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class PictureLikedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PictureLiked::class);
    }

    public function like(PictureLiked $like): void
    {
        $this->_em->persist($like);
        $this->_em->flush();
    }

    public function remove(PictureLiked $like): void
    {
        $this->_em->remove($like);
        $this->_em->flush();
    }
}