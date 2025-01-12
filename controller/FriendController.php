<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
use Model\Managers\UserManager;
use Model\Managers\PublicationManager;
use Model\Managers\FollowManager;
use Model\Managers\FavoritesManager;
use Model\Managers\TopicManager;
use Model\Managers\EventManager;

class FriendController extends AbstractController implements ControllerInterface {

    public function index(){
        
        return [

            "view" => VIEW_DIR."reseauSocial/listProfilFriends.php",
            "meta_description" => "Liste profil d'amis"

        ];
    }

}