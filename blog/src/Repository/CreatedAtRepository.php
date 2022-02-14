<?php

namespace App\Repository;

use App\Entity\CreatedAt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CreatedAt|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreatedAt|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreatedAt[]    findAll()
 * @method CreatedAt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreatedAtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreatedAt::class);
    }

    // /**
    //  * @return CreatedAt[] Returns an array of CreatedAt objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CreatedAt
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
