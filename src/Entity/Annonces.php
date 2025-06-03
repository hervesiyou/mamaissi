<?php

namespace App\Entity; 
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnnoncesRepository;
use ApiPlatform\Metadata\ApiResource;

 
#[ORM\Entity(repositoryClass: AnnoncesRepository::class)]
#[ApiResource]
#[ORM\Table(name:"hh_annonces")]

class Annonces{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id; 
     
    #[ORM\Column(type: 'string',  nullable:false)]
     public $titre;
    
    #[ORM\Column(type: 'string',  nullable:false)]
     public $contenu;
    
    #[ORM\Column(type: 'date',  nullable:false)]
     private $dateajout;
   
    public function getId() {
        return $this->id;
    }
 

    public function __construct(){
         $this->dateajout=new \Datetime();
    }    
 
    public function setTitre($titre) {
        $this->titre = $titre;    
        return $this;
    }

    public function getTitre() {
        return $this->titre;
    }

    
    public function setContenu($contenu) {
        $this->contenu = $contenu;    
        return $this;
    }

    public function getContenu() {
        return $this->contenu;
    }

  
    public function setDateajout($dateajout)  {
        $this->dateajout = $dateajout;    
        return $this;
    }

    /**
     * Get dateajout
     *
     * @return \DateTime
     */
    public function getDateajout()
    {
        return $this->dateajout;
    }
}
