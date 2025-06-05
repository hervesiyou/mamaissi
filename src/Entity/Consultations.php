<?php

namespace App\Entity;
// use ApiPlatform\Core\Annotation\ApiResource;
// use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Metadata\ApiResource;
// use ApiPlatform\Metadata\ApiSubresource;
use Doctrine\ORM\Mapping as ORM; 
//  * @ApiResource(attributes={"route_prefix"="/HHApi"})
#[ORM\Entity(repositoryClass:"App\Repository\ConsultationsRepository")]
#[ApiResource]
#[ORM\Table(name:"hh_consultations")]

class Consultations{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity:"App\Entity\Dossiermedical", inversedBy:"consultations")] 
     private $dossiermedical;

     #[ORM\Column(name:"dateconsultation", type:"datetime",   nullable:true)]    
    private $dateconsultation;

    #[ORM\Column(name:"medecin", type:"string", length:100, nullable:true)]
    private $medecin;

    #[ORM\Column(name:"donnees", type:"text", length:65535, nullable:true)]
    private $donnees;

    #[ORM\Column(name:"synthese", type:"text", length:65535, nullable:true)]   
    private $synthese;

    #[ORM\Column(name:"decision", type:"text", length:65535, nullable:true)]   
    private $decision;

    #[ORM\Column(name:"maladies", type:"text", length:65535, nullable:true)]
    private $maladies;
 
    #[ORM\Column(name:"type", type:"string", length:15, nullable:true)]     
    private $type;

    #[ORM\Column(name:"lieu", type:"string", length:120, nullable:false)]
    private $lieu;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    private ?Personnels $personnel = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ilc = null;

    #[ORM\Column(nullable: true)]
    private ?bool $imc = null;
   
    public function __toString(){
        return (string) $this->maladies;
    }
 
    public function getId() {
        return $this->id;
    }

    public function getDossiermedical()  {
        return $this->dossiermedical;
    }

    public function getDateconsultation() {
        return $this->dateconsultation;
    }

    public function getMedecin() {
        return $this->medecin;
    }

    public function getDonnees() {
        return $this->donnees;
    }

    public function getSynthese() {
        return $this->synthese;
    }

    public function getDecision() {
        return $this->decision;
    }

    public function getMaladies() {
        return $this->maladies;
    }

    public function getType() {
        return $this->type;
    }

    public function getLieu() {
        return $this->lieu;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDossiermedical($dossiermedical) {
        $this->dossiermedical = $dossiermedical;
    }

    public function setDateconsultation($dateconsultation) {
        $this->dateconsultation = $dateconsultation;
    }

    public function setMedecin($medecin) {
        $this->medecin = $medecin;
    }

    public function setDonnees($donnees) {
        $this->donnees = $donnees;
    }

    public function setSynthese($synthese) {
        $this->synthese = $synthese;
    }

    public function setDecision($decision) {
        $this->decision = $decision;
    }

    public function setMaladies($maladies) {
        $this->maladies = $maladies;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setLieu($lieu) {
        $this->lieu = $lieu;
    }

    public function getPersonnel(): ?Personnels
    {
        return $this->personnel;
    }

    public function setPersonnel(?Personnels $personnel): self
    {
        $this->personnel = $personnel;

        return $this;
    }

    public function isIlc(): ?bool
    {
        return $this->ilc;
    }

    public function setIlc(?bool $ilc): self
    {
        $this->ilc = $ilc;

        return $this;
    }

    public function isImc(): ?bool
    {
        return $this->imc;
    }

    public function setImc(?bool $imc): self
    {
        $this->imc = $imc;

        return $this;
    }



}

