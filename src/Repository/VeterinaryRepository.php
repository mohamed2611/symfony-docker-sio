<?php

namespace App\Repository;

use App\Entity\Veterinary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Veterinary>
 */
class VeterinaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Veterinary::class);
        
    }

    public function getNumberFollowsupByVeterinary(): array
    {
        return $this->createQueryBuilder('v')
        ->leftjoin('v.followUp', 'f')
        ->select('v.id')
        ->addSelect('v.name')
        ->addSelect('v.address')
        ->addSelect('v.postalCode')
        ->addSelect('v.city')
        ->addSelect('COUNT(f.id) AS number')
        ->groupBy('v.id')
        ->addGroupBy('v.name')
        ->addGroupBy('v.address')
        ->addGroupBy('v.postalCode')
        ->addGroupBy('v.city')
        ->getQuery()
        ->getResult();
    }
   

    //    /**
    //     * @return Veterinary[] Returns an array of Veterinary objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Veterinary
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
