<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;
use Model\Managers\MessageManager;

class MessageController extends AbstractController implements ControllerInterface{

    public function index() {

        // ID de l'utilisateur connecté
        $user_id = SESSION::getUser()->getId(); 

        $messageManager = new MessageManager();

        $userManager = new UserManager();

        $conversations = $messageManager->getConversations($user_id);

        // Vérifie les messages non lus
        $unreadMessagesCount = $messageManager->unreadMessagesCount($user_id);
    
        // Recherche d'utilisateur : Appel de la méthode searchUsers
        $searchResults = [];
        $search = "";
    
        // Vérifie si une recherche d'utilisateur est soumise
        if (isset($_POST['submit'])) {
            $search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);  // Récupérer la recherche
        
            // Instancier le UserManager et effectuer la recherche
            $searchResults = $userManager->searchUsers($search);  // Rechercher les utilisateurs
        }
    
        // Récupérer le destinataire si un message est envoyé
        $recipientId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        $messages = [];
        
        // Si un destinataire est sélectionné, récupérer les messages échangés
        if ($recipientId > 0) {

            // Marquer les messages comme lus 
            $readMessage = $messageManager->markAsRead($user_id, $recipientId);

            $messages = $messageManager->messagesBetweenUsers($user_id, $recipientId);
    
            $recipient = $userManager->findOneById($recipientId);
        }
        
        
        return [
            "view" => VIEW_DIR . "reseauSocial/messagerie.php",  
            "meta_description" => "Messagerie et recherche d'utilisateurs",
            "data" => [
                "messages" => $messages,
                "searchResults" => $searchResults,
                "search" => $search,
                "recipient" => isset($recipient) ? $recipient : null,
                "unreadMessagesCount" => $unreadMessagesCount,
                "conversations" => $conversations 
            ]
        ];
    }
    
    public function sendMessage($id) {

        if (isset($_POST['submit_message'])) {

            // Récupérer l'ID de l'utilisateur connecté
            $user = SESSION::getUser()->getId(); 

            // ID du destinataire
            $userId = $_GET['id']; 

            $message = filter_input(INPUT_POST, 'messages', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    
            // Vérifier que le message et le destinataire sont valides
            if (!empty($message) && $userId != $user) {

                $messageManager = new MessageManager;

                $data = ['messages' => $message, 'user_id' => $user, 'user_id_1' => $userId];
                
                $messageManager->add($data);
                
                SESSION::addFlash('success', "Message envoyé !");
    
                $this->redirectTo("message", "index&id=$id");

            } else {

                SESSION::addFlash('error', "Destinataire ou message invalide !");
            }
        }
    
        return [
            "view" => VIEW_DIR . "reseauSocial/messagerie.php",
            "meta_description" => "Messagerie et recherche d'utilisateurs"
        ];
    }

}
