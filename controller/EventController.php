<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
use Model\Managers\EventManager;
use Model\Managers\ParticipantManager;

class EventController extends AbstractController implements ControllerInterface {

    public function index() {

        $eventManager = new EventManager();

        $participantManager = new ParticipantManager();

        $limit = 8; 

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
        
        $totalEvents = $eventManager->totalEvents();
        
        // Calcul du nombre total de pages
        $totalPages = ceil($totalEvents / $limit);
    
        // Si la page est au-delà du nombre total de pages, on la redirige à la dernière page
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        
        // Récupérer les événements pour la page actuelle
        $start = ($page - 1) * $limit;

        $events = iterator_to_array($eventManager->findAllEvents($start, $limit));

        $countParticipants = [];

        foreach($events as $event){

            $limitPlace = $eventManager->limitMax($event->getId());
            
            $nombreParticipants = $participantManager->countNumberParticipants($event->getId());

            $limitMax = ($nombreParticipants >= $limitPlace);

            $countParticipants [] = [

                'id' => $event->getId(),  
                'numberParticipants' => $nombreParticipants,  
                'limitMax' => $limitMax

            ];
        
        }
        
        return [
            "view" => VIEW_DIR . "reseauSocial/listEvents.php",
            "meta_description" => "Liste des évènements",
            "data" => [
                "events" => $events,
                "totalPages" => $totalPages,
                "page" => $page,
                "countParticipants" => $countParticipants
                
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
            $limit = filter_input(INPUT_POST, "limit", FILTER_VALIDATE_INT);
            
            if($title && $text && $eventDate && $eventHours && $city && $country && $limit){

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
                $data = ['photo'=>$photo, 'title'=>$title, 'text'=>$text, 'eventDate'=>$eventDate, 'eventHours'=>$eventHours, 'city'=>$city, 'country'=>$country, 'user_id'=>$userId, 'limit'=>$limit];

                // Appelle la méthode 'add' de PublicationManager pour ajouter la nouvelle publication dans la base de données
                $eventManager->add($data);

                SESSION::addFlash('success', "L'évnèment a bien été ajouté !");

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
                        "user_id" => $userId,
                        "limit" =>  $limit
        
                    ]
                ];
            }
        }
    }

    public function deleteEvent($id){

        $eventManager = new EventManager();

        $eventManager->delete($id);

        SESSION::addFlash('success', "L'évènement a bien été supprimé !");

        $this->redirectTo("event", "index");

        return [

            "view" => VIEW_DIR."reseauSocial/listEvents.php",
            "meta_description" => "Supprimer évenements"
            
        ];
    }

    public function detailEvents($eventId){

        $userId = Session::getUser()->getId();

        $eventManager = new EventManager();

        $participantManager = new ParticipantManager();

        $event = $eventManager->findOneById($eventId);

        if ($isParticipant = $participantManager->isParticipant($eventId, $userId)) {
             
        }
        
        $limit = $eventManager->limitMax($eventId);

        $nombreParticipants = $participantManager->countNumberParticipants($eventId);

        $limitMax = ($nombreParticipants >= $limit);

        return [

            "view" => VIEW_DIR."reseauSocial/detailEvent.php",
            "meta_description" => "Détail des évenements",
            "data" => [ 
                "event" => $event,
                "limit" => $limit,
                "nombreParticipants" => $nombreParticipants,
                "limitMax" => $limitMax,
                "isParticipant" => $isParticipant
            ]
            
        ];

    } 
    
    public function addParticipant($id) {

        $userId = Session::getUser()->getId();

        $eventId = $_GET['id'];

        $eventManager = new EventManager();

        $participantManager = new ParticipantManager();

        // Si l'utilisateur est déjà inscrit, on redirige
        if ($isParticipant = $participantManager->isParticipant($eventId, $userId)) {

            SESSION::addFlash('error', "Vous participé déja à cet évènement !");
    
            $this->redirectTo("event", "detailEvents&id=$eventId");
             
        }

        $limitMax = $eventManager->limitMax($eventId);

        $nombreParticipants = $participantManager->countNumberParticipants($eventId, $userId);

        // Si la capacité est atteinte, on redirige 
        if ($nombreParticipants >= $limitMax) {

            SESSION::addFlash('error', "Cet évènement est complet !");

            $this->redirectTo("event", "detailEvents&id=$eventId");

        }

        $data = ['event_id' => $eventId, 'user_id' => $userId];

        $participantManager->add($data);

        SESSION::addFlash('success', "Votre inscription a bien été effectué !");

        $this->redirectTo("event", "detailEvents&id=$eventId");
            
    
        return [

            "view" => VIEW_DIR."reseauSocial/detailEvent.php",
            "meta_description" => "Ajouter participants"
            
            
        ];
        
    }  
    
    public function deleteParticipant($event_id) {

        $user_id = SESSION::getUser()->getId();   
    
        $participantManager = new ParticipantManager();
        
        $participantManager->deleteParticipant($event_id, $user_id);

        SESSION::addFlash('success', "Désinscription effectué !");

        $this->redirectTo("event", "detailEvents&id=$event_id");

        return [

            "view" => VIEW_DIR."reseauSocial/detailEvent.php",
            "meta_description" => "Supprimer participant"

        ];
    }
}
