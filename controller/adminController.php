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

    public function banUser($id) {
        
        $userManager = new UserManager();
    
        $userId = $userManager->findOneById($id);
    
        if ($userId) {
            
            $userManager->banUser($userId->getId()); 
    
            SESSION::addFlash('success', "L'utilisateur a été banni !");
            
        } else {
            
            SESSION::addFlash('error', "Utilisateur introuvable !");
        }
    
        $this->redirectTo("admin", "users");
    }

    public function unBanUser($id){

        $userManager = new UserManager();

        $userId = $userManager->findOneById($id);
    
        if ($userId) {
            
            $userManager->unBanUser($userId->getId()); 
    
            SESSION::addFlash('success', "L'utilisateur a été banni !");
            
        } else {
            
            SESSION::addFlash('error', "Utilisateur introuvable !");
        }
    
        $this->redirectTo("admin", "users");
        
    }

    public function changeRole() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $userId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($userId && $role) {
                
                $userManager = new UserManager();
                
                $userManager->changeRole($role, $userId);

                SESSION::addFlash('success', "Le rôle de cet utilisateur a bien été modifié !");

            } else {

                SESSION::addFlash('error', "Erreur lors de la modification du rôle !");

            }
        }
    
        $this->redirectTo("admin", "users");
    }
}