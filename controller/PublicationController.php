<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
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

            "view" => VIEW_DIR."reseauSocial/homePublications.php",
            "meta_description" => "Liste des publications Réseau Social",
            "data" => [

                "publications" => $publications

            ]
        ];
    }

    public function listPublicationsByUser(){

    }

    public function addPublication(){

        // Vérifier si le formulaire a été soumis
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            
            // La fonction filter_input() permet de valider ou nettoyer chaque donnée transmise par le formulaire en utilisant divers filtres
            // FILTER_SANITIZA_STRING supprime une chaîne de caractère de toute présence de caractères spéciaux et balise HTML potentielle ou encodes
            $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if($content){
                
                if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
                    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "webp" => "image/webp");
                    $filename = $_FILES["photo"]["name"];
                    $filetype = $_FILES["photo"]["type"];
                    $filesize = $_FILES["photo"]["size"];
                    
                    // Vérifie l'extension du fichier
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");
                    
                    // Vérifie la taille du fichier - 5Mo maximum
                    $maxsize = 5 * 1024 * 1024;
                    if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");
                    
                    // Vérifie le type MIME du fichier
                    if(in_array($filetype, $allowed)){
                        
                        // Vérifie si le fichier existe avant de le télécharger.
                        if(file_exists("upload/" . $_FILES["photo"]["name"])){
                            
                            echo $_FILES["photo"]["name"] . " existe déjà.";
                            
                        } else{
                            
                            move_uploaded_file($_FILES["photo"]["tmp_name"], "public/upload/" . $_FILES["photo"]["name"]);
                            echo "Votre fichier a été téléchargé avec succès.";
                            
                        } 

                        
                    } else{
                        
                        echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.";
                        
                    }
                    


                } else{

                    echo "Error: " . $_FILES["photo"]["error"];

                }

                $publicationManager = new PublicationManager();
                $photo = $_FILES["photo"]["name"];
                $userId = Session::getUser()->getId();
                $data = ['content'=>$content, 'photo'=>$photo, 'user_id'=>$userId];
                $publicationManager->add($data);

                $this->redirectTo($ctrl = "publication", $action = "index");
           
                return [

                    "view" => VIEW_DIR."reseauSocial/homePublications.php",
                    "meta_description" => "ajouter publication",
                    "data" => [

                        "content" => $content,
                        "photo" => $photo,
                        "user_id" => $userId
        
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

            "view" => VIEW_DIR."reseauSocial/homePublications.php",
            "meta_description" => "supprimer publication"
        ];
    }
}

    
