<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;


class SecurityController extends AbstractController{
    // contiendra les méthodes liées à l'authentification : register, login et logout

    public function register () {

        if(isset($_POST["submit"])){
            // Connexion à la base de données
            $userManager = new UserManager();

            // Filtrer la saisie des champs du formulaire
            $pseudo = filter_input(INPUT_POST, "nickname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if($pseudo && $email && $pass1 && $pass2){

                $userManager = new UserManager();

                $data = ['email'=>$email];

                $user = $userManager->findOneby($data);

                //Si l'utilisateur existe
                if($user){

                    $this->redirectTo($ctrl = "security", $action = "index");

                } else {

                    // Insertion de l'user dans la base de donnée
                    if($pass1 = $pass2 && strlen($pass1) >= 5){

                        $userManager = new UserManager();

                        $data = ['nickName'=>$pseudo, 'email'=>$email, 'password'=> password_hash($pass1, PASSWORD_DEFAULT)];

                        $userManager->add($data);
   
                    } else {

                        //message  "Les mots de passes ne sont pas identiques ou mot de passe trop court
                    }

                }
            } else{

                // problème de saisie

            }
        }
        
        // // Par défaut j'affiche le formulaire d'inscription
        $this->redirectTo($ctrl = "security", $action = "index");

    }
    // public function login () {}
    // public function logout () {}
}