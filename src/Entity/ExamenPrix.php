<?php

namespace App\Entity;

use App\Repository\ExamenPrixRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource] 
#[ORM\Entity(repositoryClass:ExamenPrixRepository::class)]
class ExamenPrix{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id; 

    #[ORM\Column(type:"string", length:255)]
    private $nom;
     
    #[ORM\Column(type:"string", length:255)]
    private $description;
 
    #[ORM\Column(type:"string", length:255)]
    private $prix;

    #[ORM\ManyToOne(inversedBy: 'examen', cascade: [ 'remove'])]
    private ?CommandeExames $commandeExames = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(string $description): self {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?string{
        return $this->prix;
    }

    public function setPrix(string $prix): self {
        $this->prix = $prix;
        return $this;
    }
    public function getNom(): ?string{
        return $this->nom;
    }

    public function setNom(string $prix): self {
        $this->nom = $prix;
        return $this;
    }

    public function getCommandeExames(): ?CommandeExames
    {
        return $this->commandeExames;
    }

    public function setCommandeExames(?CommandeExames $commandeExames): self
    {
        $this->commandeExames = $commandeExames;

        return $this;
    }
}
