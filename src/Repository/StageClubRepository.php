<?php

namespace App\Repository;

use App\Entity\StageClub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StageClub|null find($id, $lockMode = null, $lockVersion = null)
 * @method StageClub|null findOneBy(array $criteria, array $orderBy = null)
 * @method StageClub[]    findAll()
 * @method StageClub[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageClubRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StageClub::class);
    }

    // /**
    //  * @return StageClub[] Returns an array of StageClub objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StageClub
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
