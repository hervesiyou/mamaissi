<?php

namespace App\Repository;

use App\Entity\Consultationmedecins;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Consultationmedecins|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consultationmedecins|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consultationmedecins[]    findAll()
 * @method Consultationmedecins[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultationmedecinsRepository extends ServiceEntityRepository{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Consultationmedecins::class);
    }

//    /**
//     * @return Consultationmedecins[] Returns an array of Consultationmedecins objects
//     */
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
    public function findOneBySomeField($value): ?Consultationmedecins
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
