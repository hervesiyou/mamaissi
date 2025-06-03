<?php

namespace App\Repository;

use App\Entity\ExamenPrix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
 

/**
 * @method ExamenPrix|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExamenPrix|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExamenPrix[]    findAll()
 * @method ExamenPrix[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExamenPrixRepository extends ServiceEntityRepository{
    public function __construct(ManagerRegistry $registry){
        parent::__construct($registry, ExamenPrix::class);
    }

    // /**
    //  * @return ExamenPrix[] Returns an array of ExamenPrix objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExamenPrix
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
