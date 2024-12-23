<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;
use Model\Managers\FollowManager;
use Model\Managers\PublicationManager;

class SecurityController extends AbstractController{

   

    // contiendra les méthodes liées à l'authentification : register, login et logout

    public function register () {

        // Vérifie si le formulaire a été soumis en testant si le bouton "submit" est présent
        if(isset($_POST["submit"])){

        // Filtrer la saisie des champs du formulaire pour prévenir les attaques XSS et valider les données
        // Ici on utilise FILTER_SANITIZE_FULL_SPECIAL_CHARS pour assainir les caractères spéciaux et HTML
        $pseudo = filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);  
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);  
        $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);  
        $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);  

            // Vérifie que tous les champs sont remplis
            if($pseudo && $email && $pass1 && $pass2){
                
                // Crée une instance de UserManager pour gérer les utilisateurs
                $userManager = new UserManager();

                // Demande au UserManager de chercher un utilisateur avec l'email fourni
                $user = $userManager->findOneByEmail($email);
        
                // Si un utilisateur avec cet email existe déjà
                if($user){

                    // Redirige vers la page d'accueil si l'email est déjà pris (utilisateur existe déjà)
                    $this->redirectTo($ctrl = "home", $action = "index");

                } else {

                    // Si les mots de passe sont identiques et que le mot de passe est suffisamment long
                    if($pass1 === $pass2 && strlen($pass1) >= 5){

                        // Prépare les données de l'utilisateur à insérer dans la base de données
                        // Le mot de passe est hashé avec password_hash pour sécuriser le stockage
                        $data = ['nickName'=>$pseudo, 'password'=>password_hash($pass1, PASSWORD_DEFAULT), 'email'=>$email];

                        // Ajoute l'utilisateur dans la base de données via UserManager
                        $user = $userManager->add($data);


                    } else {

                    echo "Les mots de passe ne sont pas identiques ou sont trop courts.";
                    }    
                } 
            } else{

            echo "Tous les champs doivent être remplis.";
            
            }

        }
        
        // Par défaut j'affiche le formulaire d'inscription
        return [

            "view" => VIEW_DIR."home.php",
            "meta_description" => "Formulaire d'inscription"
            
        ];
    }

    public function login () {

        if(isset($_POST["submit"])){

            // Filtrer la saisie des champs du formulaire
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL); // Assainir l'email
            $password = $_POST['password'];  // Récupère le mot de passe entré par l'utilisateur
    
            // Vérifie que l'email et le mot de passe sont valides
            if($email && $password){
                
                $userManager = new UserManager();
                
                // Recherche l'utilisateur avec l'email fourni
                $user = $userManager->findOneByEmail($email);
                
                // Si l'utilisateur existe dans la base de données
                if($user){
                    
                    // Récupère le mot de passe hashé de l'utilisateur
                    $hash = $user->getPassword();
    
                    // Vérifie si le mot de passe fourni correspond au mot de passe hashé
                    if (password_verify($password, $hash)){
                        
                        // Si le mot de passe est valide, on initialise la session utilisateur
                        Session::setUser($user);

                        // Redirige vers la page des publications après connexion
                        $this->redirectTo("publication", "index");
                    }
                    else {
                        // Mot de passe incorrect, vous pouvez afficher un message d'erreur à l'utilisateur
                        echo "Mot de passe incorrect.";
                        $this->redirectTo("home", "index");
                    }
                } else {
                    // L'email n'existe pas dans la base de données, afficher un message d'erreur
                    echo "Utilisateur inconnu.";
                    $this->redirectTo("home", "index");
                }
            } else {
                // Si l'email ou le mot de passe n'est pas rempli, afficher un message d'erreur
                echo "Veuillez remplir tous les champs.";
                $this->redirectTo("home", "index");
            }
        }

        // Par défaut j'affiche le formulaire d'inscription
        return [

            "view" => VIEW_DIR."reseauSocial/homePublications.php",
            "meta_description" => "Formulaire de connexion"
        
        ];   
    }

    public function logout () {
    
        // La fonction session_unset() supprime toutes les variables de session
        // Cela permet de "déconnecter" l'utilisateur en supprimant ses données de session (comme l'ID de l'utilisateur)
        session_unset();

        // redirige l'utilisateur vers la page de connexion
        $this->redirectTo("home", "index");
        
    }

    public function profile($id) {

        $currentUserId = SESSION::getUser()->getId();
        $user_id = $_GET['id'];

        // Créer une nouvelle instance de UserManager 
        $userManager = new UserManager();

        // Recherche d'un utilisateur par son identifiant ($id) dans la base de données
        // La méthode findOneById retourne un utilisateur spécifique selon son ID
        $user = $userManager->findOneById($id);

        // Recherche des amis de l'utilisateur en utilisant la méthode findFriendsByUser du UserManager
        // Cette méthode retourne une liste des amis de l'utilisateur (s'il y en a)
        $friends = $userManager->findFriendsByUser($id);

        // Créer une nouvelle instance de PublicationManager 
        $publicationManager = new PublicationManager();

        // Recherche des publications de l'utilisateur avec la méthode findPublicationsByUser
        // Cette méthode retourne une liste de publications postées par l'utilisateur
        $publications = $publicationManager->findPublicationsByUser($id);

        //Créer une nouvelle instance de FollowManager 
        $followManager = new FollowManager();

        // Vérifier si l'utilisateur connecté suit déjà cet utilisateur
        $isFollowing = $followManager->following($currentUserId, $id);

        // Récupére le nombre de personnes suivies par l'utilisateur
        $following = $followManager->countFollowing($user_id);

        // Récupére le nombre de personnes qui suivent l'utilisateur
        $followers = $followManager->countFollowers($user_id);


        return [

            "view" => VIEW_DIR."security/profil.php",
            "meta_description" => "Profil Utilisateur",

            "data" => [

                "user" => $user,
                "friends" => $friends,
                "publications" => $publications,
                "isFollowing" => $isFollowing,
                "following" => $following,
                "followers" => $followers
                

            ]
        
        ];   

    } 
    
   
    public function editProfile($id) {

        // L'ID de l'utilisateur connecté
        $userId = SESSION::getUser()->getId(); 

        // Créaer une nouvelle instance de UserManager 
        $userManager = new UserManager();

        // Récupère les données de l'utilisateur
        $userEdit = $userManager->findOneById($id); 

        return [

            "view" => VIEW_DIR."security/profil.php",
            "meta_description" => "Modifications profil"
            
        ];
    }

    public function updateProfile($id) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = SESSION::getUser()->getId();  // L'ID de l'utilisateur connecté
            $nickName = filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL); 
            $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS); 

            // Validation des champs
            if (empty($nickName) || empty($email)) {

                echo "Le nom d'utilisateur et l'email sont obligatoires.";

                $this->redirectTo("security", "editProfile");

            }

            if($pass1 === $pass2 && strlen($pass1) >= 5){

            // Créaer une nouvelle instance de UserManager 
            $userManager = new UserManager();

            // Met à jour le profil de l'utilisateur
            $updateValid = $userManager->updateUser($id, $nickName, $email, $password->password_hash($pass1, PASSWORD_DEFAULT));

            }

            if ($updateValid) {

                echo "Profil mis à jour avec succès.";
                // Redirige l'utilisateur vers son profil
                $this->redirectTo("security", "profile");

            } else {

                echo "Une erreur est survenue lors de la mise à jour.";

                $this->redirectTo("security", "editProfile");

            }
        }
    }
}
 