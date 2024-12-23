<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\FollowManager;

class FollowController extends AbstractController{

    public function addFollow($friend_id){

        // Récupérer l'utilisateur connecté
        $user_id = SESSION::getUser()->getId();
        $dateFollow = date('Y-m-d H:i:s');
    
        // Vérifier que l'utilisateur ne s'ajoute pas lui-même
        if ($user_id == $friend_id) {
            echo "Vous ne pouvez pas vous suivre vous-même.";
            return;
        }
    
        // Instancier le FollowManager
        $followManager = new FollowManager();
    
        // Vérifier si l'utilisateur suit déjà cet ami
        $following = $followManager->following($user_id, $friend_id);
    
        if ($following) {
            // Rediriger si déjà suivi
            echo "Vous suivez déjà cet utilisateur.";
            $this->redirectTo("security", "index.php?ctrl=security&action=profile&id=$friend_id");
            return;
        }
    
        // Ajouter l'ami dans la base de données
        $data = [
            'dateFollow' => $dateFollow,
            'user_id' => $user_id,
            'user_id_1' => $friend_id
        ];
    
        $followManager->add($data);

        $this->redirectTo("security", "index.php?ctrl=security&action=profile&id=$friend_id");
    
    }

    public function deleteFollowing($friend_id) {

        $user_id = SESSION::getUser()->getId();   
    
        $followManager = new FollowManager();

        $followManager->deleteFollow($user_id, $friend_id);

        echo "Vous ne suivez plus cet utilisateur.";

        $this->redirectTo("security", "index.php?ctrl=security&action=profile&id=$friend_id");

        return [

            "view" => VIEW_DIR."security/profil.php",
            "meta_description" => "Profil Utilisateur : "

        ];

    }


}