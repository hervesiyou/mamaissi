<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Consultations;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiResource;
 
 #[ORM\Entity]
#[ApiResource]
#[ORM\Table(name:"hh_dossiermedical")]

class Dossiermedical{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\OneToMany(targetEntity:"App\Entity\Consultations",  mappedBy:"dossiermedical")]    
    private $consultations;

    #[ORM\Column(name:"datecreation", type:"datetime", nullable:true)]    
    private $datecreation;    

    #[ORM\Column(name:"lieucreation", type:"string", length:100, nullable:true)]   
    private $lieucreation; 

    #[ORM\Column(name:"tuteur", type:"string", length:200, nullable:true)]    
    private $tuteur; 

    #[ORM\Column(name:"photo", type:"string", length:120, nullable:true)]    
    private $photo;

    #[ORM\Column(name:"NumeroDossier", type:"string", length:130, nullable:false)]    
    private $numerodossier;

    #[ORM\Column(name:"EtatCivil", type:"string", length:50, nullable:true)]    
    private $etatcivil;

    #[ORM\Column(name:"GroupeSanguin", type:"string", length:10, nullable:true)]    
    private $groupesanguin;

    #[ORM\Column(name:"Rhesus", type:"string", length:10, nullable:true)]
    
    private $rhesus;

    #[ORM\Column(name:"Electrophorese", type:"string", length:100, nullable:true)]
 
    private $electrophorese;
    #[ORM\Column(name:"antecedentpersonnel", type:"text", length:1200, nullable:true)]
    
    private $antecedentpersonnel;
    #[ORM\Column(name:"antecedentfamillial", type:"text", length:2100, nullable:true)]
 
    private $antecedentfamillial;
    #[ORM\Column(name:"allergies", type:"text", length:2100, nullable:true)]
 
    private $allergies;
    #[ORM\Column(name:"facteurrisque", type:"text", length:2100, nullable:true)]
   
    private $facteurrisque;
    #[ORM\Column(name:"vaccindepistage", type:"text", length:2100, nullable:true)]
    private $vaccindepistage;
    #[ORM\Column(name:"biographie", type:"text", length:2100, nullable:true)]
    private $biographie;
    
    #[ORM\Column(name:"maladies", type:"text", length:2100, nullable:true)]
    private $maladies;

    #[ORM\OneToOne(targetEntity:"App\Entity\Patients")]
    private $patient;

    public function __construct($num=0){
        $this->numerodossier=$num;
        $this->consultations=new ArrayCollection();
    }
    public function __toString(){
        return $this->numerodossier." ".$this->id;
    }
  
    public function getId() {
        return $this->id;
    }
    public function getPatient() {
        return $this->patient;
    }
     public function setPatient($maladies){
        $this->patient=$maladies;
    }
    public function getConsultations() {
        return $this->consultations;
    }
    public function addConsultations(Consultations $application){
 
        if (!$this->consultations->contains($application)) {
            $this->consultations[] = $application;
        }
 
    }
    public function removeConsultations($application){
      $this->consultations->removeElement($application);
    }
     
    public function getAntecedentpersonnel() {
        return $this->antecedentpersonnel;
    }
    public function setAntecedentpersonnel($maladies){
        $this->antecedentpersonnel=$maladies;
    }
    public function getAntecedentfamillial() {
        return $this->antecedentfamillial;
    }
    public function setAntecedentfamillial($maladies){
        $this->antecedentfamillial=$maladies;
    }
    public function getAllergies() {
        return $this->allergies;
    }
    public function setAllergies($maladies){
        $this->allergies=$maladies;
    }
    public function getBiographie() {
        return $this->biographie;
    }
    public function setBiographie($maladies){
        $this->biographie=$maladies;
    }
    public function getVaccindepistage() {
        return $this->vaccindepistage;
    }
    public function setVaccindepistage($maladies){
        $this->vaccindepistage=$maladies;
    }
    public function getFacteurrisque() {
        return $this->facteurrisque;
    }
    public function setFacteurrisque($maladies){
        $this->facteurrisque=$maladies;
    }
    public function getMaladies() {
        return $this->maladies;
    }
    public function setMaladies($maladies){
        $this->maladies=$maladies;
    }

    public function getDatecreation() {
        return $this->datecreation;
    }

    public function getLieucreation() {
        return $this->lieucreation;
    }

    public function getTuteur() {
        return $this->tuteur;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function getNumerodossier() {
        return $this->numerodossier;
    }

    public function getEtatcivil() {
        return $this->etatcivil;
    }

    public function getGroupesanguin() {
        return $this->groupesanguin;
    }

    public function getRhesus() {
        return $this->rhesus;
    }

    public function getElectrophorese() {
        return $this->electrophorese;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDatecreation($datecreation) {
        $this->datecreation = $datecreation;
    }

    public function setLieucreation($lieucreation) {
        $this->lieucreation = $lieucreation;
    }

    public function setTuteur($tuteur) {
        $this->tuteur = $tuteur;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
    }

    public function setNumerodossier($numerodossier) {
        $this->numerodossier = $numerodossier;
    }

    public function setEtatcivil($etatcivil) {
        $this->etatcivil = $etatcivil;
    }

    public function setGroupesanguin($groupesanguin) {
        $this->groupesanguin = $groupesanguin;
    }

    public function setRhesus($rhesus) {
        $this->rhesus = $rhesus;
    }

    public function setElectrophorese($electrophorese) {
        $this->electrophorese = $electrophorese;
    }
 
}

