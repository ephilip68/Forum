<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;
use Model\Managers\FollowManager;
use Model\Managers\PublicationManager;
use Model\Managers\EventManager;
use Model\Managers\ParticipantManager;
use Model\Managers\FavoritesManager;
use Model\Managers\LikePostManager;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\CommentPostManager;
use Model\Managers\UnderCommentPostManager;
use Model\Managers\NewsletterManager;
use Model\Managers\MessageManager;

class SecurityController extends AbstractController{

    // contiendra les méthodes liées à l'authentification : register, login et logout

    public function register () {

        // Vérifie si le formulaire a été soumis en testant si le bouton "submit" est présent
        if(isset($_POST["submit"])){

        // Filtrer la saisie des champs du formulaire pour prévenir les attaques XSS et valider les données
        // Ici on utilise FILTER_SANITIZE_FULL_SPECIAL_CHARS pour assainir les caractères spéciaux et HTML
        $pseudo = filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);  
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);  
        $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);  
        $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);  
        $avatar = !empty($_POST['avatar']) ? $_POST['avatar'] : 'default-avatar.webp'; // Avatar par défaut si non spécifié

            // Vérifie que tous les champs sont remplis
            if($pseudo && $email && $pass1 && $pass2 && $avatar){

                // Vérifie si la case des CGU a été cochée
                if (!isset($_POST['accept_cgu'])) {

                    SESSION::addFlash('error', "Vous devez accepter les Conditions Générales d'Utilisation !");
                    return;
                }
                
                // Créer une nouvelle instance de UserManager 
                $userManager = new UserManager();

                // Demande au UserManager de chercher un utilisateur avec l'email fourni
                $user = $userManager->findOneByEmail($email);
        
                // Si un utilisateur avec cet email existe déjà
                if($user){

                    SESSION::addFlash('error', "Cet utilisateur existe déja !");

                    // Redirige vers la page d'accueil si l'email est déjà pris (utilisateur existe déjà)
                    $this->redirectTo($ctrl = "home", $action = "index");

                } else {

                    // Si les mots de passe sont identiques et que le mot de passe est suffisamment long
                    if($pass1 === $pass2 && strlen($pass1) >= 8){

                        $regex = '/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/';

                        if (preg_match($regex, $pass1)){

                            // Prépare les données de l'utilisateur à insérer dans la base de données
                            // Le mot de passe est hashé avec password_hash pour sécuriser le stockage
                            $data = ['nickName'=>$pseudo, 'password'=>password_hash($pass1, PASSWORD_DEFAULT), 'email'=>$email, 'avatar' => $avatar];

                            // Ajoute l'utilisateur dans la base de données via UserManager
                            $user = $userManager->add($data);

                            SESSION::addFlash('success', "Votre compte a bien été créer !");

                        }else {

                            // Si le mot de passe ne respecte pas la regex
                            SESSION::addFlash('error', "Le mot de passe doit contenir au moins une majuscule, un chiffre et un caractère spécial !");

                        }
                    } else {

                        SESSION::addFlash('error', "Les mots de passe ne sont pas identiques ou sont trop courts au moins 8 caractères(une majuscule, un chiffre, un caractère spécial) !");
                    }    
                } 
            } else{

                SESSION::addFlash('error', "Tous les champs doivent être remplis !");
            
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
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL); 
            $password = $_POST['password']; 

            // Vérification avec regex pour l'email
            $emailRegex = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/';

            if (!preg_match($emailRegex, $email)) {

                SESSION::addFlash('error', "L'email fourni est invalide !");

                $this->redirectTo("home", "index");
                return;

            }

            // Vérifie si le mot de passe respecte les conditions (une majuscule, un chiffre, un caractère spécial et un minimun de 8 caractères)
            $passwordRegex = '/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';

            if (!preg_match($passwordRegex, $password)) {

                SESSION::addFlash('error', "Le mot de passe doit contenir au moins une majuscule, un chiffre et un caractère spécial, et avoir au moins 8 caractères !");
                
                $this->redirectTo("home", "index");
                return;
            }
    
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
                        
                        if ($user->getIsBanned() == 'actif') {

                            // Si le mot de passe est valide et que l'utilisateur est actif, on initialise la session utilisateur
                            Session::setUser($user);

                            SESSION::addFlash('success', "Bienvenue sur SportLink !");

                            // Redirige vers la page reseau social après connexion
                            $this->redirectTo("publication", "index");
                        }else{

                            //Si l'utilisateur est banni, accès refusé
                            SESSION::addFlash('error', "Vous avez été banni, vous ne pouvez pas accéder au site pour le moment !");

                            $this->redirectTo("home", "index");

                        }
                    }
                    else {
                        // Mot de passe incorrect, vous pouvez afficher un message d'erreur à l'utilisateur
                        SESSION::addFlash('error', "Mot de passe incorrect !");
                        $this->redirectTo("home", "index");
                    }
                } else {
                    // L'email n'existe pas dans la base de données, afficher un message d'erreur
                    SESSION::addFlash('error', "Utilisateur inconnu !");
                    $this->redirectTo("home", "index");
                }
            } else {
                // Si l'email ou le mot de passe n'est pas rempli, afficher un message d'erreur
                SESSION::addFlash('error', "Veuillez remplir tous les champs !");
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

        SESSION::addFlash('success', "Vous vous êtes deconnecté !");

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

        // Créer une nouvelle instance de FollowManager 
        $followManager = new FollowManager();

        // Vérifier si l'utilisateur connecté suit déjà cet utilisateur
        $isFollowing = $followManager->following($currentUserId, $id);
        
        // Récupére le nombre de personnes suivies par l'utilisateur
        $following = $followManager->countFollowing($user_id);
        
        // Récupére le nombre de personnes qui suivent l'utilisateur
        $followers = $followManager->countFollowers($user_id);

        //C réer une nouvelle instance de EventManager 
        $eventManager = new EventManager();

        // Cette méthode retourne une liste des évènement postées par l'utilisateur
        $events = $eventManager->findEventByUser($id);


        return [

            "view" => VIEW_DIR."security/profil.php",
            "meta_description" => "Profil Utilisateur",

            "data" => [

                "user" => $user,
                "friends" => $friends,
                "publications" => $publications,
                "isFollowing" => $isFollowing,
                "following" => $following,
                "followers" => $followers,
                "events" => $events
                

            ]
        
        ];   

    } 

    public function addPhoto() {

        // Vérifie si le formulaire a été soumis 
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            // Vérification si un fichier photo a été téléchargé et si aucune erreur n'a été rencontrée
            if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){

                // Liste des extensions et types MIME autorisés pour l'image
                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "webp" => "image/webp");
                
                // Récupère le nom du fichier, son type MIME et sa taille
                $filename = $_FILES["photo"]["name"];
                $filetype = $_FILES["photo"]["type"];
                $filesize = $_FILES["photo"]["size"];

                // Récupère l'extension du fichier
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                // Vérifie si l'extension du fichier est dans la liste des extensions autorisées
                if(!array_key_exists($ext, $allowed)) {
                    SESSION::addFlash('error', "Sélectionner un format de fichier valide !");die; // Si l'extension n'est pas valide, on arrête l'exécution
                }

                // Vérifie la taille du fichier, ici on limite à 5Mo
                $maxsize = 5 * 1024 * 1024;
                if($filesize > $maxsize) {
                    SESSION::addFlash('error', "La taille du fichier est supérieure à la limite autorisée !");die; // Si la taille est trop grande, on arrête
                }

                // Vérifie que le type MIME du fichier est valide
                if(in_array($filetype, $allowed)){

                    // Vérifie si un fichier avec le même nom existe déjà sur le serveur
                    if(file_exists("upload/" . $_FILES["photo"]["name"])){

                        // Si le fichier existe déjà, on affiche un message d'erreur
                        echo $_FILES["photo"]["name"] . " existe déjà."; 

                    } else{
                        // Si tout est correct, on déplace le fichier téléchargé vers le dossier "public/upload"
                        move_uploaded_file($_FILES["photo"]["tmp_name"], "public/upload/" . $_FILES["photo"]["name"]);

                        // Si le téléchargement a réussi
                        SESSION::addFlash('success', "Votre fichier a été téléchargé avec succès !");
                    }

                } else{

                    // Si le type MIME n'est pas autorisé
                    SESSION::addFlash('error', "Problème lors du téléchargement. Réessayer !");
                }

                // Créer une nouvelle instance de PublicationManager 
                $userManager = new UserManager();

                $userId = SESSION::getUser()->getId();

                // Récupère le nom de la photo téléchargée
                $photo = $_FILES["photo"]["name"];

                // Appelle la méthode 'updateProfilPhoto' de UserManager pour modifier la photo dans la base de données
                $userManager->updateProfilPhoto($userId, $photo);

                SESSION::addFlash('success', "Photo de profil mis a jour !");

                // Redirige vers la page profil de l'utilisateur connecté après l'ajout
                $this->redirectTo("security", "index.php?ctrl=security&action=profile&id=$userId");

            } else{

                // Si le téléchargement du fichier a échoué, on affiche l'erreur associée
                SESSION::addFlash('error', "Erreur !");
            }
            
            return [

                "view" => VIEW_DIR."reseauSocial/homePublications.php",
                "meta_description" => "ajouter publication",
                "data" => [

                    "photo" => $photo
                    
    
                ]
            ];
            
        }    
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
            $id = SESSION::getUser()->getId(); 
            $nickName = filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL); 
            $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS); 

            // Validation des champs
            if (empty($nickName) || empty($email)) {

                SESSION::addFlash('error', "Le nom d'utilisateur et l'email sont obligatoires !");

                $this->redirectTo("security", "editProfile");

            }

            if($pass1 === $pass2 && strlen($pass1) >= 5){

            // Créaer une nouvelle instance de UserManager 
            $userManager = new UserManager();

            // Met à jour le profil de l'utilisateur
            $updateValid = $userManager->updateUser($id, $nickName, $email, $password->password_hash($pass1, PASSWORD_DEFAULT));

            }

            if ($updateValid) {

                SESSION::addFlash('success', "Profil mis à jour avec succès !");
                // Redirige l'utilisateur vers son profil
                $this->redirectTo("security", "profile");

            } else {

                SESSION::addFlash('success', "Une erreur est survenue lors de la mise à jour !");

                $this->redirectTo("security", "editProfile");

            }
        }
    }

    public function deleteAccount(){
        // Récupère les données de l'utilisateur en cours
        $user = Session::getUser();
    
        if ($user){
            $userManager = new UserManager;
            $publicationManager = new PublicationManager;
            $eventManager = new EventManager;
            $participantManager = new ParticipantManager;
            $favoritesManager = new FavoritesManager;
            $followManager = new FollowManager;
            $likePostManager = new LikePostManager;
            $messageManager = new MessageManager;
            $commentPostManager = new CommentPostManager;
            $underCommentPostManager = new UnderCommentPostManager;
            $postManager = new PostManager;
            $topicManager = new TopicManager;
            $newsletterManager = new NewsletterManager; 
    
            // Anonymiser les posts de l'utilisateur
            $postManager->anonimyzePostsByUser($user->getId());
    
            // Anonymiser les commentaires de l'utilisateur
            $commentPostManager->anonymizeCommentsByUser($user->getId());
    
            // Anonymiser les sous-commentaires de l'utilisateur
            $underCommentPostManager->anonymizeUnderCommentsByUser($user->getId());
    
            // Anonymiser les topics de l'utilisateur
            $topicManager->anonimyzeTopicByUser($user->getId());
    
            // Supprimer toutes les publications associées à l'utilisateur
            $publicationManager->delete($user->getId()); 
    
            // Supprimer tous les événements associés à l'utilisateur
            $eventManager->delete($user->getId()); 
    
            // Supprimer toutes les participations de l'utilisateur
            $participantManager->delete($user->getId()); 
    
            // Supprimer tous les favoris de l'utilisateur
            $favoritesManager->delete($user->getId()); 
    
            // Supprimer tous les suivis de l'utilisateur
            $followManager->deleteAllFollow($user->getId()); 
    
            // Supprimer tous les likes de l'utilisateur
            $likePostManager->deleteLikes($user->getId()); 
    
            // Supprimer tous les messages envoyés par l'utilisateur
            $messageManager->delete($user->getId()); 
    
            // Supprimer l'abonnement à la newsletter
            $newsletterManager->deleteNewsletters($user->getId()); 
    
            // Supprimer l'utilisateur lui-même
            $userManager->delete($user->getId()); 
    
            // Détruit la session
            Session::setUser(null);
    
            // Affiche un message de confirmation
            $_SESSION['success'] = "Votre compte a été supprimé avec succès.";
    
            // Redirige l'utilisateur
            $this->redirectTo("forum", "index");
        }
    }
}
 