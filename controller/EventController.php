<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
use Model\Managers\EventManager;

class EventController extends AbstractController implements ControllerInterface {

    public function index(){

        $eventManager = new EventManager();

        // Afficher tous les événements à venir
        $events = $eventManager->findAll();
        
        return [

            "view" => VIEW_DIR."reseauSocial/listEvents.php",
            "meta_description" => "Liste des évènements",
            "data" => [ 
                "events" => $events
            ]
        ];
    }

    public function addEvent() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $eventDate = filter_input(INPUT_POST, "eventDate", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $eventHours = filter_input(INPUT_POST, "eventHours", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $city = filter_input(INPUT_POST, "city", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $country = filter_input(INPUT_POST, "country", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if($title && $text && $eventDate && $eventHours && $city && $country){

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
                        die("Erreur : Veuillez sélectionner un format de fichier valide."); // Si l'extension n'est pas valide, on arrête l'exécution
                    }

                    // Vérifie la taille du fichier, ici on limite à 5Mo
                    $maxsize = 5 * 1024 * 1024;
                    if($filesize > $maxsize) {
                        die("Erreur : La taille du fichier est supérieure à la limite autorisée."); // Si la taille est trop grande, on arrête
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
                            echo "Votre fichier a été téléchargé avec succès."; 
                        }

                    } else{

                        // Si le type MIME n'est pas autorisé
                        echo "Erreur : Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer."; 
                    }

                } else{

                    // Si le téléchargement du fichier a échoué, on affiche l'erreur associée
                    echo "Erreur: " . $_FILES["photo"]["error"];
                }

                // Créer une nouvelle instance de PublicationManager 
                $eventManager = new EventManager();

                // Récupère le nom de la photo téléchargée
                $photo = $_FILES["photo"]["name"];

                // Récupère l'ID de l'utilisateur actuellement connecté via la session
                $userId = Session::getUser()->getId();

                // Crée un tableau associatif contenant les données à insérer dans la base de données
                $data = ['photo'=>$photo, 'title'=>$title, 'text'=>$text, 'eventDate'=>$eventDate, 'eventHours'=>$eventHours, 'city'=>$city, 'country'=>$country, 'user_id'=>$userId];

                // Appelle la méthode 'add' de PublicationManager pour ajouter la nouvelle publication dans la base de données
                $eventManager->add($data);

                // Redirige vers la page principale des publications après l'ajout
                $this->redirectTo("event", "index");
            
                return [

                    "view" => VIEW_DIR."reseauSocial/listEvents.php",
                    "meta_description" => "Ajouter évenements",
                    "data" => [

                        "photo" => $photo,
                        "title" =>$title,
                        "text" => $text,
                        "eventDate" => $eventDate,
                        "eventHours" => $eventHours,
                        "city" => $city,
                        "country" => $country,
                        "user_id" => $userId
        
                    ]
                ];
            }
        }
    }

    public function deleteEvent($id){

        $eventManager = new EventManager();

        $eventManager->delete($id);

        $this->redirectTo("event", "index");

        return [

            "view" => VIEW_DIR."reseauSocial/listEvents.php",
            "meta_description" => "Supprimer évenements"
            
        ];
    }
        
   
}
