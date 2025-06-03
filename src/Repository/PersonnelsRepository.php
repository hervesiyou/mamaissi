<?php

 



namespace App\Repository;
use App\Entity\Personnels;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use \Doctrine\ORM\QueryBuilder;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * 
 *
 * @author HERVE STEPHANE
 */

class PersonnelsRepository  extends ServiceEntityRepository{
    //put your code here
    protected $objectManager;
    public function __construct(ManagerRegistry $registry ){
        parent::__construct($registry, Personnels::class);
        // $this->objectManager = $om;
    }
    public function findMedecin($ville=null){
     
        $qb = $this->createQueryBuilder('u')->select("u");
        $qb->where("u.type = 'personnel'")->andWhere("u.valide =:room")->setParameter("room", 1);
        if(null!=$ville){    
             $qb->andWhere('u.ville = :vi')->setParameter('vi', $ville);
             $qb->orWhere('u.adresse = :ad')->setParameter('ad', $ville);
        }
        return $qb->getQuery()->getResult();
    }

	public function findLikeNom( $nom){  

        $qb=$this->createQueryBuilder('m')
            ->select('m')->andWhere("m.valide =:room")->setParameter("room", 1)
            ->orWhere("m.nom  like :nom")->setParameter("nom", '%'.$nom.'%') 
            ->orWhere("m.prenom like :obs")->setParameter("obs", '%'.$nom.'%')
            ->orWhere("m.nomComplet like :nc")->setParameter("nc", '%'.$nom.'%');        

        return $qb->getQuery()->getResult();     

    }

	public function findLikeAdresse( $nom){      

        $qb=$this->createQueryBuilder('m')
            ->select('m')->andWhere("m.valide =:room")->setParameter("room", 1) 
            ->orWhere("m.adresse  like :nom")->setParameter("nom", '%'.$nom.'%') 
            ->orWhere("m.ville like :obs")->setParameter("obs", '%'.$nom.'%');        

        return $qb->getQuery()->getResult();      

    }

	public function findLikeSpecialite( $nom){       

        $qb=$this->createQueryBuilder('m')
            ->select('m')->andWhere("m.valide =:room")->setParameter("room", 1)
            ->orWhere("m.specialite  like :nom")->setParameter("nom", '%'.$nom.'%') 
            ->orWhere("m.typepersonnel like :obs")->setParameter("obs", '%'.$nom.'%');         

        return $qb->getQuery()->getResult();      

    }
    public function findSearch($lieu,$value,$page,$limit){ 
            // dump(  $lieu, $value );
            /* je chercher les personnels par ville sexe ou specialité, nom etc
            */

            $qb = $this->createQueryBuilder('m')->select('m')->andWhere("m.valide =:room")->setParameter("room", 1) ;
            if($lieu=="ville")$qb->andWhere("m.ville like :room")->setParameter("room", '%'.$value.'%');
            if($lieu=="sexe")$qb->andWhere("m.sexe like :room")->setParameter("room", '%'.$value.'%');
            if($lieu=="specialite"){
                $qb->orWhere("m.typepersonnel like :room")->setParameter("room",'%'.$value.'%');
                $qb->orWhere("m.specialite like :room")->setParameter("room",'%'.$value.'%');
            }
            if($lieu=="nom"){
                $qb->andWhere("m.nomComplet  like :room")->setParameter("room", '%'.$value.'%');
            }
            $qb->orWhere("m.nomComplet  like :room")->setParameter("room", '%'.$value.'%');
            $qb->orWhere("m.type  like :type")->setParameter("type", '%'.$value.'%');
            $qb->orWhere("m.specialite  like :spe")->setParameter("spe", '%'.$value.'%');
            if( $lieu !==""){
                $qb->orWhere("m.typepersonnel  like :tp")->setParameter("tp", '%'.$value.'%');
            }

            if($page>0){
                $qb->setFirstResult( ($page-1)*$limit )->setMaxResults( $limit );                    
            }else{            
                $qb->setFirstResult(0 )->setMaxResults( $limit );            
            }
        return $qb->getQuery()->getResult();

    }

     public function findUser($nom,$pwd,$valide=null){

        $qb = $this->createQueryBuilder('c');       

        $qb->where('c.username = :un')->setParameter('un', $nom);
        $qb->orWhere('c.email = :un')->setParameter('un', $nom);
        $qb->andWhere('c.password = :pwd')->setParameter('pwd', $pwd);
        $qb->andWhere("c.valide =:room")->setParameter("room", 1);
       // if($valide!=null) $qb->andWhere('c.valide= :dis')->setParameter('dis', $type);
           return $qb->getQuery()->getOneOrNullResult();

    }

    public function findPersonnels( $page,$limit=12){      

        if($page>0){         

            $qb=$this->createQueryBuilder('m')
                ->select('m')->andWhere("m.valide =:room")->setParameter("room", 1) 
               // ->andWhere("e.room =:room")->setParameter("room", $topic)
               ->setFirstResult( ($page-1)*$limit )
               ->setMaxResults( $limit );
            return $qb->getQuery()->getResult();            

        }else{

            $qb=$this->createQueryBuilder('m')
                ->select('m')->andWhere("m.valide =:room")->setParameter("room", 1)
               // ->andWhere("e.room =:room")->setParameter("room", $topic)
               ->setFirstResult(0 )
               ->setMaxResults( $limit );
            return $qb->getQuery()->getResult();

        }

    }
    /**
     * @return ObjectRepository
     */

    protected function getRepository(){
        return $this->objectManager->getRepository($this);
    }    

}