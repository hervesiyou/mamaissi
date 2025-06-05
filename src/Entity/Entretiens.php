<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

 
#[ORM\Entity(repositoryClass:"App\Repository\EntretiensRepository")]
#[ApiResource()]
class Entretiens{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type:"string", length:255)]    
    private $telephone;

    #[ORM\Column(type:"string", length:255, nullable:true)]   
    private $email;

    #[ORM\Column(type:"datetime")]     
    private $date;

    #[ORM\Column(type:"string", length:255)]    
    private $ville;

    #[ORM\Column(type:"string", length:255)]    
    private $message;

    #[ORM\ManyToOne(targetEntity:"App\Entity\Patients", inversedBy:"entretiens")]   
    private $demandeur;

    #[ORM\Column(type:"string", length:255)]   
    private $dateprevue;

    public function __toString(){
        return $this->email." --" .$this->demandeur->getNom();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getTelephone(): ?string {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self{
        $this->telephone = $telephone;
        return $this;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(?string $email): self {
                $this->email = $email;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDemandeur(): ?Patients
    {
        return $this->demandeur;
    }

    public function setDemandeur(?Patients $demandeur): self
    {
        $this->demandeur = $demandeur;

        return $this;
    }

    public function getDateprevue(): ?string
    {
        return $this->dateprevue;
    }

    public function setDateprevue(string $dateprevue): self
    {
        $this->dateprevue = $dateprevue;

        return $this;
    }
}
