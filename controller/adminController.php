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

        $limit = 5; 

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
        
        $totalUsers = $manager->totalUsers();
        
        // Calcul du nombre total de pages
        $totalPages = ceil($totalUsers / $limit);
    
        // Si la page est au-delà du nombre total de pages, on la redirige à la dernière page
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        
        // Récupérer les événements pour la page actuelle
        $start = ($page - 1) * $limit;

        $users = iterator_to_array($manager->findAllUsers($start, $limit));

        return [
            
            "view" => VIEW_DIR."security\admin.php",
            "meta_description" => "Liste des utilisateurs du forum",
            "data" => [ 
                "users" => $users,
                "page" => $page,
                "totalPages" => $totalPages
            ]
        ];
    }

// Fonction pour bannir un utilisateur par son ID
public function banUser($id) {
    // Créer une nouvelle instance de UserManager
    $userManager = new UserManager();
    
    // Appel à la méthode findOneById() pour trouver un utilisateur avec l'ID donné
    $userId = $userManager->findOneById($id);

    // Vérifie si un utilisateur a été trouvé avec l'ID donné
    if ($userId) {
        
        // Si l'utilisateur existe, on appelle la méthode banUser() pour bannir cet utilisateur
        $userManager->banUser($userId->getId()); 

        // Ajout d'un message de succès à la session avec SESSION::addFlash()
        // Ce message pourra être affiché dans la vue pour informer l'administrateur que l'utilisateur a été banni
        SESSION::addFlash('success', "L'utilisateur a été banni !");
        
    } else {
        
        // Si aucun utilisateur n'a été trouvé avec cet ID, on ajoute un message d'erreur dans la session
        // Le message sera affiché pour informer l'administrateur que l'utilisateur n'existe pas
        SESSION::addFlash('error', "Utilisateur introuvable !");
    }

    // Rediriger l'administrateur vers la liste des utilisateurs dans la page d'administration
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