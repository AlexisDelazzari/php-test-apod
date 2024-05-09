<?php

namespace App\Repository;

use App\Entity\Picture;
use App\Entity\PictureLiked;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Picture>
 *
 * @method Picture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Picture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Picture[]    findAll()
 * @method Picture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Picture::class);
    }

    public function save(Picture $picture): void
    {
        $this->_em->persist($picture);
        $this->_em->flush();
    }

    //chercher une image infereur a la date donnée
    public function findPreviousImage(\DateTime $date): ?Picture
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.date < :date')
            ->andWhere('p.media_type = :media_type')
            ->setParameter('date', $date)
            ->setParameter('media_type', 'image')
            ->orderBy('p.date', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
