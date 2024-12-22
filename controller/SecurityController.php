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

        if(isset($_POST["submit"])){

            // Filtrer la saisie des champs du formulaire
            $pseudo = filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
            $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            
            if($pseudo && $email && $pass1 && $pass2){
                
                $userManager = new UserManager();
                
                //Demander au user manager d'appeler la fonction findUserByEmail
                $user = $userManager->findOneByEmail($email);
           
                //Si l'utilisateur existe
                if($user){

                    $this->redirectTo($ctrl = "home", $action = "index");

                } else {

                    // Insertion de l'user dans la base de donnée
                    if($pass1 = $pass2 && strlen($pass1) >= 5){

                        $data = ['nickName'=>$pseudo, 'password'=>password_hash($pass1, PASSWORD_DEFAULT), 'email'=>$email];

                        $user = $userManager->add($data);

                        
                    } else {

                        //message  "Les mots de passes ne sont pas identiques ou mot de passe trop court
                    }    
                } 
            } else{

                // problème de saisie

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
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
            // $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = $_POST['password'];

            // Si les filtres sont validés
            if($email && $password){
                
                $userManager = new UserManager();
                
                //Demander au user manager d'appeler la fonction findUserByEmail
                $user = $userManager->findOneByEmail($email);
                
                
                //Si l'utilisateur existe
                if($user){
                    $hash = $user->getPassword(); 
                    
                    // var_dump($password, $hash, password_verify($password, $hash));die();
                
                    // if (password_verify($password, $hash)){
                        
                        // echo "hello";
                        
                        Session::setUser($user);
                        // die;

                        $this->redirectTo("publication", "index");
            
                    // }
                    // //  else {

                        //message  "utilisateur inconnu ou mot de passe incorrect
                        
                //     }

                // }else{

                   //message  "utilisateur inconnu ou mod de passe incorrect
                }
            }
        } 
        // Par défaut j'affiche le formulaire d'inscription
        return [

            "view" => VIEW_DIR."reseauSocial/homePublications.php",
            "meta_description" => "Formulaire de connexion"
        
        ];   
    }

    public function logout () {
    
        session_unset();
    
        $this->redirectTo("home", "index");
        
    }

    public function profile($id) {

        $userManager = new UserManager();

        $user = $userManager -> findOneById($id);

        $friends = $userManager -> findFriendsByUser($id);
        $publicationManager = new PublicationManager();

        $publications = $publicationManager -> findPublicationsByUser($id);

        return [

            "view" => VIEW_DIR."security/profil.php",
            "meta_description" => "Profil Utilisateur",

            "data" => [

            'user' => $user,
            'friends' => $friends,
            'publications' => $publications

            ]
        
        ];   

    } 
    
    public function addFollow() {
        
        $user_id = SESSION::getUser()->getId();
        $user_id_1 = isset($_GET['id']) ? $_GET['id'] : null;
        $dateFollow = date('Y-m-d H:i:s');
        
        $followManager = new FollowManager();
        // Vérification si l'utilisateur tente de se suivre lui-même
        if ($user_id == $user_id_1) {
            echo "Vous ne pouvez pas vous suivre vous-même.";
            return;
        }

        // Vérifier si l'utilisateur suit déjà l'autre utilisateur
        $isFollowing = $followManager->following($user_id, $user_id_1);

        if ($isFollowing) {
            
            echo "Vous suivez déjà cet utilisateur.";
            
            $this->redirectTo("security", "index.php?ctrl=security&action=profile&id=$user_id_1");
            
        }
    
        if ($user_id != $user_id_1) {

            $data=['dateFollow'=>$dateFollow, 'user_id'=>$user_id, 'user_id_1'=>$user_id_1];

            $followManager -> add($data);

            echo "Vous suivez maintenant cet utilisateur.";

            $this->redirectTo("security", "index.php?ctrl=security&action=profile&id=$user_id_1");

        }else {
            
            echo "Une erreur est survenue lors de l'ajout du suivi.";
            
        }

        return [

            "view" => VIEW_DIR."security/profil.php",
            "meta_description" => "Ajouter Follower",

            "data" => [

                "isFollowing" => $isFollowing,
                "user_id_1" => $user_id_1
            ]
        
        ];   
        
    }

    public function deleteFollowing() {

        $user_id = SESSION::getUser()->getId(); 
        $user_id_1 = isset($_GET['id']) ? $_GET['id'] : null;  
    
        
        $followManager = new FollowManager();

        $followManager->deleteFollow($user_id, $user_id_1);

        echo "Vous ne suivez plus cet utilisateur.";

        $this->redirectTo("security", "index.php?ctrl=security&action=profile&id=$user_id_1");

        return [

            "view" => VIEW_DIR."security/profil.php",
            "meta_description" => "Profil Utilisateur"

        ];

    }

    public function countFollowing($user_id){

        $followManager = new FollowManager();

        $countFollowing = $followManager->countFollowing($user_id);

        var_dump($countFollowing);die;

        return [
            "view" => VIEW_DIR . "security/profil.php",
            "meta_description" => "Compte le nombre de personnes suivies",
            "data" => [
                "countFollowing" => $countFollowing
            ]
        ];

    }

    public function countFollowers($user_id_1){

        $followManager = new FollowManager();

        $countFollowers = $followManager->countFollowers($user_id_1);

        return [

            "view" => VIEW_DIR."security/profil.php",
            "meta_description" => "Compte le nombre de followers",
            "data" => [
                
                "countFollowers" => $countFollowers
            ]
        ];

    }
}
 