<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;
use Model\Managers\PublicationManager;


class PublicationController extends AbstractController implements ControllerInterface {

    public function index() {
        
        // créer une nouvelle instance de PublicationManager
        $publicationManager = new PublicationManager();

        // récupérer la liste de toutes les publications grâce à la méthode findAll de Manager.php (triés par nom)
        $publications = $publicationManager->findAll();

        // le controller communique avec la vue "listPublication" (view) pour lui envoyer la liste des publications (data)
        return [

            "view" => VIEW_DIR."reseauSocial/listPublications.php",
            "meta_description" => "Liste des publications Réseau Social",
            "data" => [

                "publications" => $publications

            ]
        ];
    }

    public function listPublicationsByUser(){

    }

    public function addPublication(){

        if(isset($_POST["submit"])){
            
            // La fonction filter_input() permet de valider ou nettoyer chaque donnée transmise par le formulaire en utilisant divers filtres
            // FILTER_SANITIZA_STRING supprime une chaîne de caractère de toute présence de caractères spéciaux et balise HTML potentielle ou encodes
            $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if($content){

                $publicationManager = new PublicationManager();

                $data = ['content'=>$content];

                $publicationManager->add($data);

                $this->redirectTo($ctrl = "publication", $action = "index");

                return [

                    "view" => VIEW_DIR."reseauSocial/listPublications.php",
                    "meta_description" => "ajouter publication",
                    "data" => [

                        "content" => $content
        
                    ]
                ];
            }
        }    
    }

    public function deletePublication($id){

        $publicationManager = new PublicationManager();

        $publicationManager->delete($id);

        $this->redirectTo($ctrl = "publication", $action = "index");

        return [

            "view" => VIEW_DIR."reseauSocial/listPublications.php",
            "meta_description" => "supprimer publication"
        ];
    }
}
