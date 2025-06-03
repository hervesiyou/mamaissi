<?php



/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */


namespace App\Repository;
use Doctrine\Persistence\ManagerRegistry;



use App\Entity\Examens;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use \Doctrine\ORM\QueryBuilder;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**

 * Description of RoomRepository

 *

 * @author HERVE STEPHANE

 */

class ExamensRepository extends ServiceEntityRepository{
    //put your code here   
    protected $objectManager;   

    public function __construct(ManagerRegistry $registry ){
        parent::__construct($registry, Examens::class);
        // $this->objectManager = $om;
    }

    public function findByNameManif( $nom){             

        $qb=$this->createQueryBuilder('m')
            ->select('m') 
            ->orWhere("m.description like :room")->setParameter("room", '%'.$nom.'%')
            ->orWhere("m.codeexamen like :manif")->setParameter("manif", '%'.$nom.'%');
          //->setFirstResult( ($page-1)*$limit )
          // ->setMaxResults( $limit );
           //echo $qb->getQuery()->getSQL();
        return $qb->getQuery()->getResult();          

    }

    public function findMaladies( $nomcause){
        $qb=$this->createQueryBuilder('m')
           ->select('m') 
           //->orWhere("m.manifestation like :room")->setParameter("room", '%'.$nomcause.'%')
           ->orWhere("m.description like :nom")->setParameter("nom", '%'.$nomcause.'%');            

        return $qb->getQuery()->getResult(); 

    }

    public function findExamens( $page,$limit=12){       

        if($page>0){         

            $qb=$this->createQueryBuilder('m')
                ->select('m') 
               // ->andWhere("e.room =:room")->setParameter("room", $topic)
               ->setFirstResult( ($page-1)*$limit )
               ->setMaxResults( $limit );
            return $qb->getQuery()->getResult();             

        }else{

            $qb=$this->createQueryBuilder('m')
                ->select('m') 
               // ->andWhere("e.room =:room")->setParameter("room", $topic)
               ->setFirstResult(0 )
               ->setMaxResults( $limit );
            return $qb->getQuery()->getResult();
        }

    }

    /**
     * @return ObjectRepository
     */
    protected function getRepository() {
        return $this->objectManager->getRepository($this);
    }

    

    

}