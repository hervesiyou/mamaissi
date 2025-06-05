<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
 
#[ORM\Table(name:"hh_examens")]
#[ORM\Entity(repositoryClass:"App\Repository\ExamensRepository")]
class Examens{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
     private $id;    
 
    #[ORM\Column(name:"cout", type:"integer", nullable:true)]
    private $cout;
 
    #[ORM\Column(name:"dateexamen", type:"date", nullable:true)]
    private $dateexamen;
   
    #[ORM\Column(name:"preacquis", type:"text", nullable:true)]
    private $preacquis;
     
    #[ORM\Column(name:"description", type:"text", nullable:true)]
    private $description;
    
    #[ORM\Column(name:"resultats", type:"text", nullable:true)]
    private $resultat;
     
    #[ORM\Column(name:"codeExamen", type:"string", length:60,nullable:true)]      
    private $codeexamen;

    #[ORM\Column(length: 255)]
    private ?string $maladies = null;
    
    public function __construct(){
      
    }
    
      public function __toString() {
            return (string) $this->description;
      }
      
      public function getId(): ?int {
            return $this->id;
      }

      public function getDescription() {
            return $this->description;
      }
      public function setDescription($name) {
            $this->description = $name;
            return $this;
      }
      public function getMaladie() {
            return $this->maladie;
        }
        public function setMaladie($name) {
            $this->maladie = $name;
            return $this;
        }
        public function getDateexamen() {
            return $this->dateexamen;
        }
        public function setDateexamen($name) {
            $this->dateexamen = $name;
            return $this;
        }
      public function getCodeexamen() {
          return $this->codeexamen;
      }
      public function setCodeexamen($name) {
          $this->codeexamen = $name;
          return $this;
      }
      public function getResultat() {
        return $this->resultat;
    }
    public function setResultat($name) {
        $this->resultat = $name;
        return $this;
    }
    public function getCout() {
      return $this->cout;
    }
    public function setCout($name) {
        $this->cout = $name;
        return $this;
    }
    public function getPreacquis() {
        return $this->preacquis;
    }
    public function setPreacquis($name) {
        $this->preacquis = $name;
        return $this;
    }

    public function getMaladies(): ?string
    {
        return $this->maladies;
    }

    public function setMaladies(string $maladies): static
    {
        $this->maladies = $maladies;

        return $this;
    }



}

