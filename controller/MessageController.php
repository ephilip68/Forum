<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;
use Model\Managers\MessageManager;

class MessageController extends AbstractController implements ControllerInterface{

    public function index() {
        
        // créer une nouvelle instance de CategoryManager
        // $messageManager = new MessageManager();

        // récupérer la liste de tous les messages grâce à la méthode findAll de Manager.php (triés par nom)
        // $messages = $messageManager->findAll();

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)



        return [

            "view" => VIEW_DIR."reseauSocial/messagerie.php",
            "meta_description" => "Liste des messages"
          
        ];
    }

    public function sendMessage() {

        if (isset($_POST['submit'])) {
            // Récupérer les informations de l'utilisateur actuel (l'expéditeur)
            $user_id = SESSION::getUser()->getId();
            $user_id_1 = $_POST['user_id_1'];  // ID du destinataire
            $message = $_POST['messages'];  // Contenu du message
    
            // Assurez-vous que le destinataire est valide et que le message n'est pas vide
            if (!empty($message) && $user_id_1 != $user_id) {
                $messageManager = new MessageManager;
                  
                // Crée un tableau associatif contenant les données à insérer dans la base de données
                $data = ['messages'=>$message, 'user_id'=>$user_1, 'user_id_1'=>$user_id_1];

                // Appelle la méthode 'add' de Manager pour ajouter la nouvelle publication dans la base de données
                $messageManager->add($data);
    
                echo "Message envoyé avec succès!";
                $this->redirectTo('message', 'index');  // Rediriger vers la boîte de réception
            } else {
                echo "Le message est vide ou le destinataire est invalide.";
            }
        }
    }

    public function reception() {

        $user_id = SESSION::getUser()->getId();  // ID de l'utilisateur connecté
    
        $messageManager = new MessageManager;

        $messages = $messageManager->getMessages($user_id);
    
        return [

            "view" => VIEW_DIR."reseauSocial/messagerie.php",
            "meta_description" => "Liste des messages",
            "data" => [

                "messages" => $messages

            ]
            
        ];
    }

    public function markAsRead() {

        if (isset($_GET['id'])) {
            $message_id = $_GET['id'];
    
            $messageManager = new MessageManager($this->pdo);
            $messageManager->markAsRead($message_id);
    
            $this->redirectTo('messages', 'inbox');  // Rediriger vers la boîte de réception
        }
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
}
