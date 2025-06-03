<?php

namespace App\Entity;

use App\Entity\Patients;
use App\Entity\Personnels;
use Doctrine\ORM\Mapping as ORM;

 
#[ORM\Table(name:"hh_rendezvous")]
#[ORM\Entity]
 
class Rendezvous{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
      
    #[ORM\ManyToOne(targetEntity:"App\Entity\Patients", inversedBy:"rendezvous")]
    #[ORM\JoinColumn(name:"rdvpatient_id", referencedColumnName:"id", onDelete:"CASCADE") ]     
     private $patient;
      
    #[ORM\ManyToOne(targetEntity:"App\Entity\Personnels", inversedBy:"rendezvous")]
    #[ORM\JoinColumn(name:"rdvpersonnelsante_id", referencedColumnName:"id", onDelete:"CASCADE") ]     
     private $personnel;
 
    #[ORM\Column(name:"jour", type:"string", length:20, nullable:true)]      
    private $jour;
 
    #[ORM\Column(name:"mois", type:"string", length:20, nullable:true)]     
    private $mois;
 
    #[ORM\Column(name:"annee", type:"string", length:10, nullable:true)]    
    private $annee;
 
    #[ORM\Column(name:"etat", type:"string", length:50, nullable:true)]      
    private $etat;    
    #[ORM\Column(name:"but", type:"text", length:65535, nullable:true)]     
    private $but;
    
    #[ORM\Column(name:"datecreation", type:"datetime",  nullable:false)]     
    private $datecreation;
     
    #[ORM\Column(name:"date", type:"string",  nullable:true)]     
    private $date;
 
    #[ORM\Column(name:"heurevalide", type:"string", length:50, nullable:false)]     
    private $heurevalide;
     
    #[ORM\Column(name:"heure", type:"string", length:50, nullable:true)]     
    private $heure;
   
    #[ORM\Column(name:"quartier", type:"string", length:50, nullable:true)]     
    private $quartier;
    
    #[ORM\Column(name:"region", type:"string", length:50, nullable:false)]     
    private $region;
   
    #[ORM\Column(name:"ville", type:"string", length:50, nullable:false)]     
    private $ville;
     
    #[ORM\Column(name:"prix", type:"string", length:50, nullable:false)]    
    private $prix;
    
    #[ORM\Column(name:"specialite", type:"string", length:50, nullable:false)]     
    private $specialite;
 
    #[ORM\Column(name:"coderdv", type:"string", length:100, nullable:true)]     
    private $coderdv;
    
    #[ORM\Column(name:"modevisio", type:"string", length:100, nullable:true)]     
    private $modevisio;    
    #[ORM\Column(name:"codepatient", type:"string", length:100, nullable:true)]    
    private $codepatient;
 
    #[ORM\Column(name:"titreconf", type:"string", length:100, nullable:true)]     
    private $titreconf;
     
    #[ORM\Column(name:"dateconf", type:"string", length:200, nullable:true)]     
    private $dateconf;
     
    #[ORM\Column(name:"idconf", type:"string", length:100, nullable:true)]    
    private $idconf;
     
     #[ORM\Column(name:"cssclass", type:"string", length:100, nullable:true)]    
    private $cssclass;
    
     #[ORM\Column(name:"etatpaiement", type:"string", length:100, nullable:true)]     
    private $etatpaiement;
     
     #[ORM\Column(name:"datepaiement", type:"datetime", length:100, nullable:true)]      
    private $datepaiement;
     
     #[ORM\Column(name:"code", type:"string", length:300, nullable:true)]      
    private $code;
    
    public function __construct() {
        $this->heurevalide="non";
        $this->datecreation=new \Datetime("now");
        $this->etat="Pas encore Validé";

        $random = sprintf(sha1($this->getId()."".time()), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
        $random = str_pad($random, 10, '0', STR_PAD_LEFT); 

        $this->code= substr($random,0,10);
    }
    public function __toString() {
        return $this->codepatient." ".$this->specialite;
    }
    public function getCode() {
        return $this->code;
    }
    public function getModevisio() {
        return $this->modevisio;
    }
    public function getTitreconf() {
        return $this->titreconf;
    }
    public function getDateconf() {
        return $this->dateconf;
    }
    public function getIdconf() {
        return $this->idconf;
    }
    public function getCssclass() {
        return $this->cssclass;
    }
    public function getEtatpaiement() {
        return $this->etatpaiement;
    }
    public function getDatepaiement() {
        return $this->datepaiement;
    }
    public function setTitreconf($patient) {
        $this->titreconf = $patient;
        return $this;
    }
    public function setModevisio($patient) {
        $this->modevisio = $patient;
        return $this;
    }
    public function setDateconf($patient) {
        $this->dateconf = $patient;
        return $this;
    }
    public function setIdconf($patient) {
        $this->idconf = $patient;
        return $this;
    }
    public function setCssclass($patient) {
        $this->cssclass = $patient;
        return $this;
    }
    public function setEtatpaiement($patient) {
        $this->etatpaiement = $patient;
        return $this;
    }
    public function setCode($patient) {
        $this->code = $patient;
        return $this;
    }
    public function setDatepaiement($patient) {
        $this->datepaiement = $patient;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function getPatient() {
        return $this->patient;
    }
    public function getSpecialite() {
        return $this->specialite;
    }

    public function getPersonnel() {
        return $this->personnel;
    }

    public function getJour() {
        return $this->jour;
    }

    public function getMois() {
        return $this->mois;
    }

    public function getAnnee() {
        return $this->annee;
    }

    public function getEtat() {
        return $this->etat;
    }

    public function getBut() {
        return $this->but;
    }
public function getDate()  {
        return $this->date;
    }
    public function getHeure()  {
        return $this->heure;
    }
    public function getDatecreation()  {
        return $this->datecreation;
    }

    public function getHeurevalide() {
        return $this->heurevalide;
    }

    public function getQuartier() {
        return $this->quartier;
    }

    public function getRegion() {
        return $this->region;
    }

    public function getVille() {
        return $this->ville;
    }

    public function getCoderdv() {
        return $this->coderdv;
    }
    public function getPrix() {
        return $this->prix;
    }

    public function getCodepatient() {
        return $this->codepatient;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    public function setSpecialite($id) {
        $this->specialite = $id;
        return $this;
    }

    public function setPatient($patient) {
        $this->patient = $patient;
        return $this;
    }

    public function setPersonnel($personnel) {
        $this->personnel = $personnel;
        return $this;
    }

    public function setJour($jour) {
        $this->jour = $jour;
        return $this;
    }

    public function setMois($mois) {
        $this->mois = $mois;
        return $this;
    }
    public function setPrix($mois) {
        $this->prix = $mois;
        return $this;
    }

    public function setAnnee($annee) {
        $this->annee = $annee;
        return $this;
    }

    public function setEtat($etat) {
        $this->etat = $etat;
        return $this;
    }

    public function setBut($but) {
        $this->but = $but;
        return $this;
    }
public function setDate( $datecreation) {
        $this->date = $datecreation;
        return $this;
    }
    public function setHeure( $datecreation) {
        $this->heure = $datecreation;
        return $this;
    }
    public function setDatecreation( $datecreation) {
        $this->datecreation = $datecreation;
        return $this;
    }

    public function setHeurevalide($heurevalide) {
        $this->heurevalide = $heurevalide;
        return $this;
    }

    public function setQuartier($quartier) {
        $this->quartier = $quartier;
        return $this;
    }

    public function setRegion($region) {
        $this->region = $region;
        return $this;
    }

    public function setVille($ville) {
        $this->ville = $ville;
        return $this;
    }

    public function setCoderdv($coderdv) {
        $this->coderdv = $coderdv;
        return $this;
    }

    public function setCodepatient($codepatient) {
        $this->codepatient = $codepatient;
        return $this;
    }



}

