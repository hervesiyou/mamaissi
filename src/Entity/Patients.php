<?php

namespace App\Entity;


use App\Entity\Programmes;
use App\Entity\Commandemedicaments;
use App\Repository\PatientsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Dossiermedical;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Rendezvous;
use ApiPlatform\Core\Annotation\ApiResource;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
 
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
 
#[ApiResource]
#[Vich\Uploadable]
#[ORM\Table(name:"hh_patients")]
#[ORM\Entity(repositoryClass: PatientsRepository::class)]

class Patients  implements \JsonSerializable, UserInterface, PasswordAuthenticatedUserInterface{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    
    #[ORM\Column(name:"age", type:"integer", nullable:true)]     
    private $age;
     
    #[ORM\Column(type:"string", length:255,nullable:true)]      
    protected $image;

    #[Vich\UploadableField(mapping:"patients_images", fileNameProperty:"image")]     
    protected $imageFile;
   
    #[ORM\OneToMany(targetEntity:"App\Entity\Rendezvous",  mappedBy:"patient")]      
    private $rendezvous;
    
    #[ORM\OneToOne(targetEntity:"App\Entity\Dossiermedical", cascade:["persist"])]      
    private $dossiermedical;

    #[ORM\Column(name:"profession", type:"string",nullable:true)]     
    private $profession;

    #[ORM\Column(name:"statutmatrimonial", type:"string",nullable:true)]     
    private $statutmatrimonial;

    #[ORM\Column(name:"valide", type:"boolean")]     
    protected $valide = false;

    #[ORM\Column(type:"string",nullable:true)]      
    protected $nomComplet;
    
    #[ORM\Column(name:"sexe", type:"string", length:255,nullable:true)]     
    protected $sexe;

    #[ORM\Column(name:"nom", type:"string", length:255,nullable:true)]     
    protected $nom;

    #[ORM\Column(name:"prenom", type:"string", length:255,nullable:true)] 
    #[Assert\NotBlank()]    
    protected $prenom;
 
    #[ORM\Column(type:"string")]
     #[Assert\NotBlank()]
     #[Assert\Length(min:4, minMessage:"votre pseudo doit faire au moins 4 caractères.")]      
    private $username;
 
    #[ORM\Column(type:"string", unique:true,nullable:true)] 
    #[Assert\Email()]     
    private $email;
 
    #[ORM\Column(type:"string", length:64)]
    #[Assert\Length(min:4, minMessage:"Votre mot de passe doit faire au moins 4 caractères.")]     
    private $password;
    
    #[ORM\Column(name:"adresse", type:"text",nullable:true)]    
    protected $adresse;

    #[ORM\Column(name:"zip_code", type:"string", length:255,nullable:true)]   
    protected $zipCode;

    #[ORM\Column(name:"ville", type:"string", length:255,nullable:true)]      
    protected $ville;

    #[ORM\Column(name:"pays", type:"string", length:255,nullable:true)]    
    protected $pays;

    #[ORM\Column(name:"type", type:"string", length:255,nullable:true)]      
    protected $type = "patient";

    #[ORM\Column(name:"telephone", type:"string", length:255,nullable:true)]     
    protected $telephone;

    #[ORM\Column(type:"datetime",nullable:true)]     
    private $date_naiss;

    #[ORM\Column(type:"datetime",nullable:true)]  
    private $dateLastconnection;

    #[ORM\Column(type:"datetime",nullable:true)]     
    private $date_validation;

    #[ORM\Column(type:"datetime",nullable:true)]     
    private $date_inscription;

    #[ORM\Column(type:"datetime",nullable:true)]    
    private $datereinitialisation;

    #[ORM\Column(name:"shortcode", type:"string", length:50,nullable:true)]      
    protected $shortcode;

    #[ORM\Column(name:"token", type:"string",nullable:true)]      
    protected $token;

    #[ORM\Column(name:"oldpwdlist", type:"text", nullable:true)]     
    protected $oldpwdlist;

    #[ORM\Column(name:"nombreenfant", type:"integer",nullable:true)]     
    private $nombreenfant;   

    #[ORM\Column(name:"mobiletelephone", type:"string", length:255,nullable:true)]     
    protected $mobiletelephone;

    #[ORM\Column(name:"nbvisite", type:"integer",nullable:true)]    
    private $nbvisite;

    // #[ORM\OneToMany(targetEntity :Commandemedicaments::class, mappedBy:"patient")]     
    // private $commandemedicaments;

    #[ORM\OneToMany(targetEntity :"App\Entity\Entretiens", mappedBy:"demandeur")]     
    private $entretiens;
    
    #[ORM\ManyToMany(targetEntity:"App\Entity\Programmes")]
    #[ORM\JoinTable(
          name:"patient_programme_table",
          joinColumns:[new JoinColumn(name:"patients_id", referencedColumnName:"id") ] ,
          inverseJoinColumns: [ new JoinColumn(name:"programmes_id", referencedColumnName:"id", unique:false) ]
        )
    ]      
    private $programmes;
 

    public function __construct() {
       
        $this->date_inscription=new \Datetime("now");
        $this->dateLastconnection=new \Datetime("now");
        $this->enabled = false;
        $this->age = 0;
        $this->nbvisite = 0;        
        $this->rendezvous=new ArrayCollection();
        $this->entretiens = new ArrayCollection();
        $this->programmes = new ArrayCollection();

        // $this->commandemedicaments = new ArrayCollection();
    }
    public function getSlug(){
        return str_replace(" ","-",$this->nom."-".$this->prenom);
    }
    public function getId(){
        return $this->id;
    
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
        ];
    } 

    public function setNombreenfant($nombreenfant){
        $this->nombreenfant = $nombreenfant;    
        return $this;
    }

    /**
     * Get nombreenfant
     * @return integer
     */
    public function getNombreenfant(){
        return $this->nombreenfant;
    }

    public function setImageFile($image = null){
      $this->imageFile = $image;       
      if ($image) {
          // if 'updatedAt' is not defined in your entity, use another property
         // $this->date_upd = new \DateTime('now');
      }
    }

    public function getImageFile(){
        return $this->imageFile;
    }

    public function setImage($image){
        $this->image = $image;
    }

    public function getToken(){
        return $this->token;
    }
     public function setToken($image){
        $this->token = $image;
    }
    public function getNbvisite(){
        return $this->nbvisite;
    }
     public function setNbvisite($image){
        $this->nbvisite = $image;
    }

    public function getImage(){
        return $this->image;
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
    
    public function __toString(){
        return (string) $this->nomComplet." ," .$this->ville;
    }    
    
    /**     
     * @param integer $age
     * @return Patients
     */
    public function setAge($age){
        $this->age = $age;    
        return $this;
    }
    /**
     * Set age
     * @param integer $age
     * @return Patients
     */
    public function setStatutMatrimonial($age){
        $this->statutmatrimonial = $age;    
        return $this;
    }

    /**  
     * @return  Dossiermedical
     */
    public function getDossiermedical(){
        return $this->dossiermedical;
    }
    public function setDossiermedical(Dossiermedical $image = null){
        $this->dossiermedical = $image;
    }
    /**
     * Get age 
     * @return integer
     */
    public function getAge(){
        return $this->age;
    }
    /**
     * Get age     *
     * @return string
     */
    public function getStatutMatrimonial(){
        return $this->statutmatrimonial;
    }

     public  function getDateLastconnection(){
        return $this->dateLastconnection;
    }
     public function setDateLastconnection($date){
        $this->dateLastconnection=$date;
    }
    public  function getDateNaiss(){
        return $this->date_naiss;
    }
     public function setDateNaiss($date){
        $this->date_naiss=$date;
    }

    public  function getDateValidation(){
        return $this->date_validation;
    }
    public  function getDateInscription(){
        return $this->date_inscription;
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
 
    public function setusername(string $username): void {
        $this->username = $username;
    }
    
    public function getSexe(): ?string {
        return $this->sexe;
    }
 
    public function setSexe(string $sexe): void {
        $this->sexe = $sexe;
    }
 
    public function getEmail(): ?string{
        return $this->email;
    }
 
    public function setEmail(string $email): void {
        $this->email = $email;
    }
 
    public function getPassword(): ?string {
        return $this->password;
    }
 
    public function setPassword(string $password): void {
        $this->password = $password;
    }
 
    public function getNom(): ?string {
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
    
    public function getAdresse(): ?string {
        return $this->adresse;
    }
 
    public function setadresse(string $adresse): void {
        $this->adresse = $adresse;
    }
    
    public function getZipCode(): ?string  {
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
    
    public function getTelephone(): ?string{
        return $this->telephone;
    }
 
    public function setTelephone(string $telephone): void{
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
     public function getVille(): ?string {
        return $this->ville;
    }
 
    public function setVille(string $ville): void
    {
        $this->ville = $ville;
    }
     public function getValide(){
        return $this->valide;
    } 
    public function setValide($ville): void{
        $this->valide = $ville;
    }

   

     public function getProfession(): ?string
    {
        return $this->profession;
    }
 
    public function setProfession(string $ville): void
    {
        $this->profession = $ville;
    }
    public function setType(string $ville): void
    {
        $this->type = $ville;
    }
    
    public function serialize(): string{
        return serialize([$this->id, $this->username, $this->password]);
    }
 
    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void{
        [$this->id, $this->username, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }

    /**
     * @return Collection|Entretiens[]
     */
    public function getEntretiens(): Collection {
        return $this->entretiens;
    }

    public function addEntretien(Entretiens $entretien): self {
        if (!$this->entretiens->contains($entretien)) {
            $this->entretiens[] = $entretien;
            $entretien->setDemandeur($this);
        }
        return $this;
    }

    public function removeEntretien(Entretiens $entretien): self {
        if ($this->entretiens->contains($entretien)) {
            $this->entretiens->removeElement($entretien);
            // set the owning side to null (unless already changed)
            if ($entretien->getDemandeur() === $this) {
                $entretien->setDemandeur(null);
            }
        }
        return $this;
    }    
    public function getProgrammes()  {
        return $this->programmes;
    }

    public function addProgramme(Programmes $entretien): self {
        if ($this->programmes != null && !$this->programmes->contains($entretien)) {
            $this->programmes[] = $entretien;
            $entretien->setPatient($this);
        }
        return $this;
    }

    public function removeProgramme(Programmes $entretien): self {
        if ($this->programmes->contains($entretien)) {
            $this->programmes->removeElement($entretien);
            // set the owning side to null (unless already changed)
            if ($entretien->getPatient() === $this) {
                $entretien->setPatient(null);
            }
        }
        return $this;
    }
/*
    public function getCommandemedicaments()  {
        return $this->commandemedicaments;
    }
    public function addCommandemedicaments(Commandemedicaments $patient): self{
        if (!$this->commandemedicaments->contains($patient)) {
            $this->commandemedicaments[] = $patient;
            $patient->setPatient($this);
        }
        return $this;
    }

    public function removeCommandemedicaments(Commandemedicaments $patient): self{
        if ($this->commandemedicaments->removeElement($patient)) {
            // set the owning side to null (unless already changed)
            if ($patient->getPatient() === $this) {
                $patient->setPatient(null);
            }
        }
        return $this;
    }
*/
    

    public function getUserIdentifier(): string {
        return $this->email; // Retournez l'identifiant unique de l'utilisateur
    }

    public function getRoles(): array {
        return ['ROLE_USER']; // Retournez les rôles de l'utilisateur
    }

    public function eraseCredentials(): void
    {
        // Si vous stockez des données sensibles, vous pouvez les effacer ici
    }
     
}
