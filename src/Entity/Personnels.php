<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Rendezvous;
use App\Entity\SpecialistePrix;
use ApiPlatform\Core\Annotation\ApiResource;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
 
#[ORM\Table(name:"hh_personnels")]
#[ORM\Entity(repositoryClass:"App\Repository\PersonnelsRepository")]
#[ApiResource]
#[Vich\Uploadable]

class Personnels implements \JsonSerializable{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;  
     
    #[ORM\Column(type:"string", length:255, nullable:true)]
    protected $image;

    #[Vich\UploadableField(mapping:"personnels_images", fileNameProperty:"image")]
    #[Assert\File(maxSize:"5M", )]
    
    protected $imageFile;
    #[ORM\Column(type:"string", length:255, nullable:true)]     
    protected $cv;

    #[Vich\UploadableField(mapping:"personnels_cvs", fileNameProperty:"cv")]
    #[Assert\File(maxSize:"5M")]     
    protected $cvFile;

    #[ORM\Column(type:"string", length:255, nullable:true)]      
    protected $diplome;
	
    #[Vich\UploadableField(mapping:"personnels_diplomes", fileNameProperty:"diplome")]
    #[Assert\File(maxSize:"5M")]    
    protected $diplomeFile;
    
    #[ORM\OneToMany(targetEntity:"App\Entity\Rendezvous",  mappedBy:"personnel")]
    private $rendezvous;
     
    // #[ORM\OneToMany(targetEntity:"Notes",  mappedBy:"personnel")]
    // private $notes;
    
    // #[ORM\Column(name:"typepersonnel", type:"string", length:255,nullable:true)]
    // private $typepersonnel;
    
    #[ORM\Column(name:"specialite", type:"string", length:255)]
    private $specialite;
     
    #[ORM\Column(name:"valide", type:"boolean")]
    protected $valide = false;
 
    #[ORM\Column(name:"diplomevalide", type:"boolean")]
    protected $diplomevalide = false;
 
    #[ORM\Column(name:"prixconsultation", type:"integer", nullable:true)]
    private $prixconsultation;
     
    #[ORM\Column(name:"nbvisite", type:"integer", nullable:true)]
    private $nbvisite;
 
    #[ORM\Column(type:"string", nullable:true)]
    protected $nomComplet;
     
    #[ORM\Column(name:"sexe", type:"string", length:255, nullable:true)]
    protected $sexe;
 
    #[Assert\Length(min:3)]
    #[ORM\Column(name:"nom", type:"string", length:255, nullable:true)]
    protected $nom;
 
    #[ORM\Column(name:"prenom", type:"string", length:255, nullable:true)]
    protected $prenom;
  
    #[ORM\Column(type:"string", unique:true)]
    #[Assert\NotBlank()]
    private $username;
  
    #[ORM\Column(type:"string", unique:true, nullable:true)]
    #[Assert\Email()]
    private $email; 
     
    #[Assert\Length(min:5 ,minMessage:"Au moins  caractères")]
    #[ORM\Column(type:"string", length:64)]
    private $password;
     
    #[ORM\Column(name:"adresse", type:"text", nullable:true)]
    protected $adresse;
 
    #[ORM\Column(name:"zip_code", type:"string", length:255, nullable:true)]
    protected $zipCode;
     
    #[ORM\Column(name:"ville", type:"string", length:255, nullable:false)]
    protected $ville;
    
    #[ORM\Column(name:"pays", type:"string", length:255, nullable:true)]
    protected $pays;
    
    #[ORM\Column(name:"type", type:"string", length:255, nullable:true)]
    protected $type;

   
    #[ORM\Column(name:"telephone", type:"string", length:255, nullable:true)]
    protected $telephone;

    #[ORM\Column(type:"datetime", nullable:true)]     
    private $date_naiss;

    #[ORM\Column(type:"datetime", nullable:true)]    
    private $date_validation;

    #[ORM\Column(type:"datetime", nullable:true)]
     
    private $date_inscription;
    
    #[ORM\Column(type:"datetime", nullable:true)]
    
    private $datereinitialisation;
    
    #[ORM\Column(type:"datetime", nullable:true)]
    private $dateLastconnection;
    
    #[ORM\Column(name:"shortcode", type:"string", length:50, nullable:true)]
    protected $shortcode;
   
    #[ORM\Column(name:"oldpwdlist", type:"text",  nullable:true)]
    protected $oldpwdlist;
    
    #[ORM\Column(name:"token", type:"string", nullable:true)]
    protected $token;
 
    #[ORM\Column(name:"mobiletelephone", type:"string", length:255, nullable:true)]
    protected $mobiletelephone;
  

    #[ORM\Column(nullable: true)]
    private ?bool $imc = null;

    #[ORM\OneToMany(mappedBy: 'personnel', targetEntity: Consultations::class)]
    private Collection $consultations;	
    
    public function __toString()  {
        return $this->nom ." ".$this->getPrenom();
    }
    
    public function __construct() {
       // parent::__construct();
         $this->diplomevalide = false;
         $this->imc = false;
         $this->nbvisite = 0;
        $this->date_inscription = new \Datetime("now");
        $this->date_naiss = new \Datetime("2000-01-01");
        $this->dateLastconnection = new \Datetime("now");

        $this->rendezvous=new ArrayCollection();
        //$this->notes=new ArrayCollection();
        $this->nomComplet=$this->nom." ".$this->prenom;
        
        $this->consultations = new ArrayCollection();
    }
    public function getSlug(){
        return str_replace(" ","-",$this->nom."-".$this->prenom);
    }
     public function getNbvisite(){
        return $this->nbvisite;
    }
     public function setNbvisite($image){
        $this->nbvisite = $image;
    }
    public function getDateLastconnection(): ?\DateTimeInterface
    {
        return $this->dateLastconnection;
    }
   
     public function setDateLastconnection($date){
        $this->dateLastconnection=$date;
    }
    public function getToken(){
        return $this->token;
    }
     public function setToken($image){
        $this->token = $image;
    }

     public function setShortcode($image){
        $this->shortcode = $image;
    }

    public function getShortcode(){
        return $this->shortcode;
    }
     public function setOldpwdlist($image){
        $this->oldpwdlist = $image;
    }

    public function getOldpwdlist(){
        return $this->oldpwdlist;
    }
    public function setDatereinitialisation($image){
        $this->datereinitialisation = $image;
    }

    public function getDatereinitialisation(){
        return $this->datereinitialisation;
    }


    public function getId() {
        return $this->id;
    }

    public function setImageFile($image = null){
      $this->imageFile = $image; 
      if ($image) {
           
      }
    }

    public function getImageFile(){
        return $this->imageFile;
    }

    public function setImage($image){
        $this->image = $image;
    }
    public function getImage(){
         return $this->image;
    }



    public function getCv(){
        return $this->cv;
    }
     public function setCv($image){
        $this->cv = $image;
    }
     public function setCvFile($image = null){
      $this->cvFile = $image;  
      if ($image) {
           
      }
    }

    public function getCvFile(){
        return $this->cvFile;
    }

     public function getDiplome(){
        return $this->diplome;
    }
     public function setDiplome($image){
        $this->diplome = $image;
    }
     public function setDiplomeFile($image = null){
      $this->diplomeFile = $image; 
      if ($image) {
           
      }
    }
    public function getDiplomeFile(){
        return $this->diplomeFile;
    }
     public function getDiplomevalide() 
    {
        return $this->diplomevalide;
    }
    public function setDiplomevalide(  $ville): void{
        $this->diplomevalide = $ville;
    }
   
     
	
	public function jsonSerialize(): array{
                                return [            
                                    'nom' => $this->nom,
                                    'prenom' => $this->prenom,
                                    'nomcomplet' => $this->nomComplet,
                                    'ville'  => $this->ville,
                                    'telephone'  => $this->telephone, 
                                    'sexe'  => $this->sexe, 
                                    'adresse'  => $this->adresse, 
                                    'typepersonnel'  => $this->typepersonnel, 	
                                    'specialite'  => $this->specialite, 
                                    'prixconsultation'  => $this->prixconsultation, 
                                ];
                            }
    public function getRendezvous() {
        return $this->rendezvous;
    }
    public function addRendezvous(Rendezvous $application){
 
        if (!$this->rendezvous->contains($application)) {
            $this->rendezvous[] = $application;
        }
 
    }
    public function removeRendezvous($application){
      $this->rendezvous->removeElement($application);
    }
    /*
    public function getNotes() {
        return $this->notes;
    }
    public function addNotes(Notes $application){
 
        if (!$this->notes->contains($application)) {
            $this->notes[] = $application;
        }
 
    }
    public function removeNotes($application){
      $this->notes->removeElement($application);
    }
    */

   
    // public function setTypepersonnel($typepersonnel){
    //     $this->typepersonnel = $typepersonnel;    
    //     return $this;
    // }

    // public function getTypepersonnel() {
    //     return $this->typepersonnel;
    // }
  
    public function setSpecialite($specialite) {
        $this->specialite = $specialite;    
        return $this;
    }

 
    public function getSpecialite() {
        return $this->specialite;
    }

 
    public function setPrixconsultation($prixconsultation) {
        $this->prixconsultation = $prixconsultation;    
        return $this;
    }

    public function getPrixconsultation() {
        return $this->prixconsultation;
    }



     public  function getDateNaiss(){
        return $this->date_naiss;
    }
    public  function getDateValidation(){
        return $this->date_validation;
    }
    public  function getDateInscription(){
        return $this->date_inscription;
    }
    public function setDateNaiss($date){
        $this->date_naiss=$date;
    }
    public function setDateValidation($date){
        $this->date_validation=$date;
    }
    public function setDateInscription($date){
        $this->date_inscription=$date;
    }
    public function setNomComplet(string $fullName): void {
        $this->nomComplet = $fullName;
    }
 
    // le ? signifie que cela peut aussi retourner null
    public function getNomComplet(){
        return $this->nomComplet;
    }
 
    public function getusername(){
        return $this->username;
    }
 
    public function setusername(string $username): void
    {
        $this->username = $username;
    }
    
    public function getSexe(): ?string
    {
        return $this->sexe;
    }
 
    public function setSexe(string $sexe): void
    {
        $this->sexe = $sexe;
    }
 
    public function getEmail(): ?string
    {
        return $this->email;
    }
 
    public function setEmail(string $email): void{
        $this->email = $email;
    }
 
    public function getPassword(): ?string
    {
        return $this->password;
    }
 
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
 
    public function getNom(): ?string
    {
        return $this->nom;
    }
    public function getType(): ?string
    {
        return $this->type;
    }
 
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }
    
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }
 
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }
    
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }
 
    public function setadresse(  $adresse): void
    {
        $this->adresse = $adresse;
    }
    
    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }
 
    public function setZipCode(string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }
    
    public function getPays(): ?string
    {
        return $this->pays;
    }
 
    public function setPays(string $pays): void
    {
        $this->pays = $pays;
    }
    
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }
 
    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }
    
    public function getMobiletelephone(): ?string
    {
        return $this->mobiletelephone;
    }
 
    public function setMobiletelephone(string $mobiletelephone): void
    {
        $this->mobiletelephone = $mobiletelephone;
    }
     public function getVille(): ?string
    {
        return $this->ville;
    }
 
    public function setVille(string $ville): void
    {
        $this->ville = $ville;
    }
     public function getValide() 
    {
        return $this->valide;
    }
 
    public function setValide(  $ville): void
    {
        $this->valide = $ville;
    }
    public function setType(string $ville): void
    {
        $this->type = $ville;
    }
    
     public function serialize(): string
    {
        return serialize([$this->id, $this->username, $this->password]);
    }
 
    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void
    {
        [$this->id, $this->username, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }

      

    public function addNote(Notes $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setPersonnel($this);
        }

        return $this;
    }

    public function removeNote(Notes $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            // set the owning side to null (unless already changed)
            if ($note->getPersonnel() === $this) {
                $note->setPersonnel(null);
            }
        }

        return $this;
    }
  

    public function getTypepersonnel(): ?SpecialistePrix {
        return $this->typepersonnel;
    }

    public function setTypepersonnel(?SpecialistePrix $typepersonnel0): self{
        $this->typepersonnel = $typepersonnel0;
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

    /**
     * @return Collection<int, Consultations>
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultations $consultation): self
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations->add($consultation);
            $consultation->setPersonnel($this);
        }

        return $this;
    }

    public function removeConsultation(Consultations $consultation): self
    {
        if ($this->consultations->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getPersonnel() === $this) {
                $consultation->setPersonnel(null);
            }
        }

        return $this;
    }
      
}
