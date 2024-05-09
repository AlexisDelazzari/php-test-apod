<?php

namespace App\Repository;

use App\Entity\PictureLiked;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PictureLiked>
 *
 * @method PictureLiked|null find($id, $lockMode = null, $lockVersion = null)
 * @method PictureLiked|null findOneBy(array $criteria, array $orderBy = null)
 * @method PictureLiked[]    findAll()
 * @method PictureLiked[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
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
