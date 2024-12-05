<?php

namespace App\Repository;

use App\Entity\FollowUp;
use App\Entity\Veterinary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FollowUp>
 */
class FollowUpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FollowUp::class);
    }

    public function findByVeterinary(Veterinary $veterinary): array
{
    return $this->createQueryBuilder('f')
        ->andWhere('f.veterinary = :veterinary')
        ->setParameter('veterinary', $veterinary)
        ->orderBy('f.date', 'DESC')
        ->getQuery()
        ->getResult();
}

    //    /**
    //     * @return FollowUp[] Returns an array of FollowUp objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?FollowUp
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
