<?php

namespace App\Repository;

use App\Entity\Veterinary;
use App\Entity\Activity;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;


/**
 * @extends ServiceEntityRepository<Veterinary>
 */
class VeterinaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Veterinary::class);
    }

     /**
     * @return Veterinary[]
     */
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

    /**
     * @return int
     */
    public function countNewVetsInMonth(): int
    {
        $debut = new \Datetime('first day of this month');
        $fin = new \DateTime('last day of this month');
        return $this->createQueryBuilder('v')
            ->select('count(v.id) as newVetsNumber')
            ->where('v.creationDate BETWEEN :startDate and :endDate')
            ->setParameter('startDate', $debut)
            ->setParameter('endDate', $fin)
            ->getQuery()
            ->getResult(Query::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * @return int
     */
    public function countAllVets(): int
    {
        return $this->createQueryBuilder('v')
            ->select('count(v.id) AS vetsNumber')
            ->getQuery()
            ->getResult(Query::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * @param Activity $activity
     * @return Veterinary[]
     */
    public function findByActivity(Activity $activity)
    {
        return $this->createQueryBuilder('v')
            ->innerJoin('v.activities', 'a')
            ->where('a.id = :idActivity')
            ->setParameter('idActivity', $activity->getId())
            ->getQuery()
            ->getResult();
    }


    
    /**
     * @param Category $category
     * @return Veterinary[]
     */
    public function findByCategory(Category $category) 
    {

        return $this->createQueryBuilder('v')
        ->innerJoin('v.category', 'c')
        ->where('c.id = :idCategory')
        ->setParameter('idCategory', $category->getId())
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
