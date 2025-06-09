<?php

namespace App\Controller;

use App\Entity\Programmes;
use App\Entity\Consultations;
use App\Entity\Examens;
use App\Entity\ExamenPrix;
use App\Entity\Rendezvous;
use App\Entity\Annonces;
use App\Entity\Patients;
use App\Entity\Dossiermedical;
use App\Entity\CommandeExames;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
 
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface; 
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\SerializerInterface;


 #[Route('/api', name: 'app_api_controller')]
final class ApiController extends AbstractController {

    public function __construct(  
        private RequestStack $requestStack,
        private EntityManagerInterface $em,
        private SerializerInterface $serializer
    ){ 

    }

    #[Route('/', name: 'app_api')]
    public function index(): Response {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    #[Route('/allprogrammes')]
    public function allprogrammes() {
        $reponse =  [];
        $all = $this->em->getRepository(Programmes::class)->findAll();

        foreach($all as $prog){
            $reponse[] =[
                "duree" => $prog->getDuree(),
                "nom" => $prog->getNom(),
                "description" => $prog->getDescription(),
                "prix" => $prog->getPrix(),
                "avantages" => $prog->getAvantages(),
            ];
        } 
        return new JsonResponse( $reponse );
    }

    #[Route('/allconsultations')]
    public function allconsultations() {
        $reponse = [];
         $all = $this->em->getRepository(Consultations::class)->findAll();

        foreach($all as $prog){
            $reponse[] =[
                "dossier" => $prog->getDossiermedical()?->getNumerodossier(),
                "date" => $prog->getDateconsultation(),
                "medecin" => $prog->getPersonnel(),
                "donnees" => $prog->getDonnees(),
                "syntheses" => $prog->getSynthese(),
                "decisions" => $prog->getDecision(),
                "maladies" => $prog->getMaladies(),
                "type" => $prog->getType(),
                "lieu" => $prog->getLieu(),
                "ilc" => $prog->isIlc(),
            ];
        } 
        return new JsonResponse( $reponse );
    }

    #[Route('/allexamens')]
    public function allexamens() {
        $reponse = [];
        $all = $this->em->getRepository(Examens::class)->findAll();

        foreach($all as $prog){
            $reponse[] =[
                "cout" => $prog->getCout(),
                "date" => $prog->getDateexamen(),
                "description" => $prog->getDescription(),
                "preacquis" => $prog->getPreacquis(),
                "resultats" => $prog->getResultat(),
                "maladies" => $prog->getMaladies(),
            ];
        }
        return new JsonResponse( $reponse );
    }

    #[Route('/allexamenprix')]
    public function allexamenprix() {
        $reponse = [];
        $all = $this->em->getRepository(ExamenPrix::class)->findAll();

        foreach($all as $prog){
            $reponse[] =[
                "nom" => $prog->getNom(),
                "prix" => $prog->getPrix(),
                "description" => $prog->getDescription(),
                "commande" => $prog->getCommandeExames(),                 
            ];
        }
        return new JsonResponse( $reponse );
    }

    #[Route('/allrdv')]
    public function allrdv() {
        $reponse = [];
        $all = $this->em->getRepository(Rendezvous::class)->findAll();

        foreach($all as $prog){
            $reponse[] =[
                "cout" => $prog->getCout(),
                "date" => $prog->getJour()."/".$prog->getMois()."/".$prog->getAnnee(),
                "but" => $prog->getBut(),
                "region" => $prog->getRegion(),
                "personnel" => $prog->getPersonnel(),
                "patient" => $prog->getPatient(),
            ];
        }
        return new JsonResponse( $reponse );
    }

    #[Route('/allconseils')]
    public function allconseils() {
        $reponse = [];
        $all = $this->em->getRepository(Annonces::class)->findAll();

        foreach($all as $prog){
            $reponse[] =[
                "titre" => $prog->getTitre(),
                 "contenu" => $prog->getContenu(),
                "datejout" => $prog->getDateajout()                 
            ];
        }
        return new JsonResponse( $reponse );
    }

    #[Route('/allcommunautes')]
    public function allcommunautes() {
        $reponse = [];
        return new JsonResponse( $reponse );
    }

    #[Route('/patient/{code}', name: 'api_get_patient_by_code', methods: ['GET'])]
    public function getPatientByCode(string $code): JsonResponse {
        $patient = $this->em->getRepository(Patients::class)->findOneBy(['shortcode' => $code]);

        if (!$patient) {
            return new JsonResponse(['error' => 'Patient non trouvé'], 404);
        }

        // On retourne les champs utiles du patient
        $data = [
            'email' => $patient->getEmail(),
            'sexe' => $patient->getSexe(),
            'nom' => $patient->getNom(),
            'prenom' => $patient->getPrenom(),
            'username' => $patient->getUsername(),
            'email' => $patient->getEmail(),
            // Ajoute d'autres champs si besoin
        ];

        return new JsonResponse($data, 200);
    }


    #[Route('/register', name: 'api_register', methods: ['POST'])]
    public function register( Request $request,   ): JsonResponse {
        // 🔹 Décoder le JSON reçu depuis l'app mobile
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email'], $data['password'])) {
            return $this->json(['error' => 'Champs requis manquants (email, password)'], 400);
        }

        $email = $data['email'];
        $password = $data['password'];
        $username = $data['username'];
        $nom = $data['nom'] ?? null;
        $prenom = $data['prenom'] ?? null;

        // 🔹 Vérifier si l'utilisateur existe déjà
        $existingUser = $this->em->getRepository(Patients::class)->findOneBy(['email' => $email]);
        if ($existingUser) {
            return $this->json(['error' => 'Cet utilisateur existe déjà.'], 409);
        }

        // 🔹 Créer le nouvel utilisateur
        $user = new Patients();
        $user->setEmail($email);
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setNomcomplet($prenom . " " .$nom);
        $user->setUsername($username);
        
        $user->setPassword(sha1( $password )); 
        $this->em->persist($user);
        $this->em->flush();

        return $this->json(['message' => 'Inscription réussie', 'user_id' => $user->getId()], 201);
    }

    #[Route('/login', name: 'api_login', methods: ['POST'])]
    public function login( Request $request,  ): JsonResponse {
        
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return $this->json(['error' => 'Email et mot de passe requis'], 400);
        }

        $user = $this->em->getRepository(Patients::class)->findOneBy(['email' => $email, "password"=>sha1($password)]);

        if (!$user ) {
            return $this->json(['error' => 'Identifiants incorrects'], 401);
        } 

        return $this->json([
            'message' => 'Connexion réussie',
            'user_id' => $user->getId(),
            'email' => $user->getEmail(),
            'nom' => $user->getNom()
        ]);
    }

    #[Route('/password/reset', name: 'api_password_request', methods: ['POST'])]
    public function requestReset(Request $request): JsonResponse  {

        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;

        if (!$email) {
            return $this->json(['error' => 'Email requis'], 400);
        }

        $user = $this->em->getRepository(Patients::class)->findOneBy(['email' => $email]);
        if (!$user) {
            return $this->json(['error' => 'Utilisateur introuvable'], 404);
        }

        $token = bin2hex(random_bytes(32));
        $user->setResetToken($token);
        $user->setResetRequestAt(new \DateTime());

        $this->em->flush();

        // Exemple : envoi par email
        // $mailer->send(/* ton message contenant le token */);

        return $this->json(['message' => 'Lien de réinitialisation envoyé dans votre email']);
    }

    #[Route('/password/confirm', name: 'api_password_confirm', methods: ['POST'])]
    public function confirmReset( Request $request, ): JsonResponse {

        $data = json_decode($request->getContent(), true);

        $token = $data['token'] ?? null;
        $newPassword = $data['password'] ?? null;

        if (!$token || !$newPassword) {
            return $this->json(['error' => 'Token et nouveau mot de passe requis'], 400);
        }

        $user = $this->em->getRepository(Patients::class)->findOneBy(['resetToken' => $token]);
        if (!$user) {
            return $this->json(['error' => 'Lien invalide ou expiré'], 400);
        }

        $user->setPassword(sha1($newPassword));
        $user->setResetToken(null);
        $user->setResetRequestAt(null);

        $this->em->flush();

        return $this->json(['message' => 'Mot de passe mis à jour avec succès']);
    }

    #[Route('/patient/{id}/examens', name: 'api_user_examens', methods: ['GET'])]
    public function getUserExamens(int $id): JsonResponse {

        $user = $this->em->getRepository(Patients::class)->find($id);
        if (!$user) {
            return $this->json(['error' => 'Utilisateur introuvable'], 404);
        }
        $commandes = $this->em->getRepository(CommandeExames::class)->findBy(["patient" => $user]);
        $data = [];

        foreach ($commandes as $com) {
            foreach ($com->getExamen() as $examen) {
                $data[$com->getId()][] = [
                    'cout' => $examen->getCout(),
                    'code' => $examen->getCodeexamen(),
                    'date' => $examen->getDateexamen()?->format('Y-m-d'),
                    'description' => $examen->getDescription(),
                    'preacquis' => $examen->getPreacquis(),
                    'resultat' => $examen->getResultat(),
                    'maladies' => $examen->getMaladies(),
                ];
            }
        }

        return $this->json($data);
    }

    #[Route('/patient/{id}/programmes', name: 'api_user_programmes', methods: ['GET'])]
    public function getUserProgrammes(int $id): JsonResponse {

        $user = $this->em->getRepository(Patients::class)->find($id);
        if (!$user) {
            return $this->json(['error' => 'Utilisateur introuvable'], 404);
        } 

        $programmes = $user->getProgrammes(); 
        $data = [];
        foreach ($programmes as $examen) {
            $data[] = [
                'duree' => $examen->getDuree(),
                'nom' => $examen->getNom(),
                'prix' => $examen->getPrix(),
                'avantages' => $examen->getAvantages(),
                'date' => $examen->getDateinscription()?->format('Y-m-d'),
                'description' => $examen->getDescription(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/patient/{id}/consultations', name: 'api_user_consultations', methods: ['GET'])]
    public function getUserconsultations(int $id): JsonResponse {

        $dossier = $this->em->getRepository(Dossiermedical::class)->find($id);
        if (!$dossier) {
            return $this->json(['error' => 'Dossier de cet Utilisateur introuvable'], 404);
        } 

        $consultations = $dossier->getConsultations(); 
        $data = [];

        foreach ($consultations as $examen) {
            $data[] = [
                'lieu' => $examen->getLieu(),
                'medecin' => $examen->getPersonnel()?->getNom(),
                'donnees' => $examen->getDonnees(),
                'synthese' => $examen->getSynthese(),
                'maladies' => $examen->getMaladies(),
                'decision' => $examen->getDecision(),
                'date' => $examen->getDateconsultation()?->format('Y-m-d'),
                'type' => $examen->getType(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/patient/{id}/rdv', name: 'api_user_rdvs', methods: ['GET'])]
    public function getUserrdv(int $id): JsonResponse {
        
        $user = $this->em->getRepository(Patients::class)->find($id);
        if (!$user) {
            return $this->json(['error' => 'Utilisateur introuvable'], 404);
        } 

        $programmes = $user->getRendezvous(); 
        $data = [];
        foreach ($programmes as $examen) {
            $data[] = [
                
                'date' => $examen->getJour()."/".$examen->getMois()."/".$examen->getAnnee(),
                'medecin' => $examen->getPersonnel()?->getNom(),
                'etat' => $examen->getEtat(),
                'but' => $examen->getBut(),
                'quartier' => $examen->getQuartier(),
                'region' => $examen->getRegion(),
                'ville' => $examen->getVille(),
                'prix' => $examen->getPrix(),
                'mode' => $examen->getModevisio(),
             
            ];
        }

        return $this->json($data);
    }



}
