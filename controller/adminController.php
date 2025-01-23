<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
use Model\Managers\UserManager;


class adminController extends AbstractController implements ControllerInterface {

    public function users(){

        $this->restrictTo("ROLE_ADMIN");

        $manager = new UserManager();

        $users = $manager->findAll(['dateInscription', 'DESC']);

        return [
            
            "view" => VIEW_DIR."security\admin.php",
            "meta_description" => "Liste des utilisateurs du forum",
            "data" => [ 
                "users" => $users
            ]
        ];
    }
}