<?php

namespace App\Entity;

use App\Repository\CommandeExamesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Entity(repositoryClass: CommandeExamesRepository::class)]
class CommandeExames {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'commandeExames', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patients $patient = null;

    #[ORM\OneToMany(mappedBy: 'commandeExames', targetEntity: ExamenPrix::class)]
    private Collection $examen;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateajout = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dateeffectuation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $domicile = null;

    #[ORM\Column]
    private ?bool $labo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $region = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $quartier = null;

    public function __construct() {
        $this->examen = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getPatient(): ?Patients{
        return $this->patient;
    }

    public function setPatient(Patients $patient): self {
        $this->patient = $patient;
        return $this;
    }

    /**
     * @return Collection<int, ExamenPrix>
     */
    public function getExamen(): Collection{
        return $this->examen;
    }

    public function addExamen(ExamenPrix $examan): self {
        if (!$this->examen->contains($examan)) {
            $this->examen->add($examan);
            $examan->setCommandeExames($this);
        }

        return $this;
    }

    public function removeExamen(ExamenPrix $examan): self {
        if ($this->examen->removeElement($examan)) {
            // set the owning side to null (unless already changed)
            if ($examan->getCommandeExames() === $this) {
                $examan->setCommandeExames(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): self{
        $this->description = $description;

        return $this;
    }

    public function getDateajout(): ?\DateTimeInterface{
        return $this->dateajout;
    }

    public function setDateajout(?\DateTimeInterface $dateajout): self {
        $this->dateajout = $dateajout;
        return $this;
    }

    public function getDateeffectuation() {
        return $this->dateeffectuation;
    }

    public function setDateeffectuation(string $dateeffectuation): self {
        $this->dateeffectuation = $dateeffectuation;
        return $this;
    }

    public function isDomicile(): ?bool {
        return $this->domicile;
    }

    public function setDomicile(?bool $domicile): self
    {
        $this->domicile = $domicile;

        return $this;
    }

    public function isLabo(): ?bool
    {
        return $this->labo;
    }

    public function setLabo(bool $labo): self
    {
        $this->labo = $labo;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getQuartier(): ?string
    {
        return $this->quartier;
    }

    public function setQuartier(?string $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }
}
