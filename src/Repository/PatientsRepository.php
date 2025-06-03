<?php





namespace App\Repository;
use App\Entity\Patients;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
// use \Doctrine\ORM\QueryBuilder;
// use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Persistence\ManagerRegistry;

class PatientsRepository extends ServiceEntityRepository{
//    protected $objectManager; 
    public function __construct(ManagerRegistry $registry ) {
        parent::__construct($registry, Patients::class);
        // $this->objectManager = $om;
    } 

    /**
     * @return ObjectRepository
     */
    protected function getRepository(){
        return $this->objectManager->getRepository($this);
    }

    public function findPatient($ville=null){   

        $qb = $this->createQueryBuilder('u');
        $qb->andWhere("u.type = 'patient'"); 
        if(null!=$ville){   
            $qb->andWhere('u.ville = :vi')->setParameter('vi', $ville);
        }
       // echo $qb->getQuery()->getSQL();
        return $qb->getQuery()->getResult();
    }

     public function findUser($nom,$pwd,$type=null){
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.username = :un')->setParameter('un', $nom);
        $qb->orWhere('c.email = :un')->setParameter('un', $nom);
        $qb->andWhere('c.password = :pwd')->setParameter('pwd', $pwd);
        if($type!=null) $qb->andWhere('c.valide = :dis')->setParameter('dis', $type);
       // echo $qb->getQuery()->getSQL();
       // echo "<br/>".$nom.", ".$pwd.",".$type;
        return $qb->getQuery()->getOneOrNullResult();
    }

}

