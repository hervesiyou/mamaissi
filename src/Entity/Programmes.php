<?php

namespace App\Entity;


use App\Entity\Patients;
use Doctrine\ORM\Mapping as ORM;

 
#[ORM\Table(name:"hh_programmes")]
#[ORM\Entity]

class Programmes{

#[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column(type: 'integer')]
private $id;

#[ORM\Column(name:"dateinscription", type:"datetime",   nullable:true)]
private $dateinscription; 

#[ORM\Column(name:"delai", type:"string",   nullable:true)]   
private $duree;

#[ORM\Column(name:"titre", type:"string",   nullable:false)]
private $nom;

#[ORM\Column(name:"slug", type:"string",   nullable:false)]
private $slug;

#[ORM\Column(name:"description", type:"text",   nullable:true)]     
private $description;

#[ORM\Column(length: 255, nullable: true)]
private ?string $prix = null;

#[ORM\Column(length: 255, nullable: true)]
private ?string $avantages = null;
 
public function __consctruct(){
    $this->dateinscription = new \Datetime("now");
    $this->slug = str_replace(" ","-", $this->nom);
}

public function __toString() {
    if($this->patient){
        return $this->nom." ".$this->patient->getNom();
    }else{
        return $this->nom;
    }
}

public function getId() {
    return $this->id;
}

public function getDateinscription() {
    return $this->dateinscription;
}
public function setDateinscription($datecreation){
    $this->dateinscription = $datecreation;    
    return $this;
}
public function getNom() {
    return $this->nom;
}
public function setNom($datecreation){
    $this->nom = $datecreation;    
    return $this;
} 
public function getSlug() {
    return $this->slug;
}
public function setSlug($datecreation){
    $this->slug = $datecreation;    
    return $this;
} 
public function getDescription() {
    return $this->description;
}
public function setDescription($datecreation){
    $this->description = $datecreation;    
    return $this;
}  
public function getDuree() {
    return $this->duree;
}
public function setDuree($datecreation){
    $this->duree = $datecreation;    
    return $this;
}

public function getPrix(): ?string
{
    return $this->prix;
}

public function setPrix(?string $prix): static
{
    $this->prix = $prix;

    return $this;
}

public function getAvantages(): ?string
{
    return $this->avantages;
}

public function setAvantages(?string $avantages): static
{
    $this->avantages = $avantages;

    return $this;
} 

}