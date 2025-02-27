<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
use Model\Managers\EventManager;
use Model\Managers\ParticipantManager;
use Model\Managers\FollowManager;

class EventController extends AbstractController implements ControllerInterface {

    public function index() {
        // Crée une instance du gestionnaire d'événements
        $eventManager = new EventManager();
        // Crée une instance du gestionnaire de participants
        $participantManager = new ParticipantManager();
        // Définit le nombre maximum d'événements à afficher par page
        $limit = 8; 
        // Récupère le numéro de la page actuelle depuis l'URL (paramètre 'page'), sinon définit la page à 1 par défaut
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
        // Récupère le nombre total d'événements dans la base de données
        $totalEvents = $eventManager->totalEvents();
        // Calcule le nombre total de pages en divisant le nombre total d'événements par la limite (arrondi à l'entier supérieur)
        $totalPages = ceil($totalEvents / $limit);
        // Si la page demandée est supérieure au nombre total de pages, redirige l'utilisateur vers la dernière page
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        // Calcule l'index de départ pour récupérer les événements de la page actuelle
        $start = ($page - 1) * $limit;
        // Récupère les événements pour la page actuelle à partir de la méthode findAllEvents et les convertit en tableau
        $events = iterator_to_array($eventManager->findAllEvents($start, $limit));
        // Initialise un tableau pour stocker les informations sur le nombre de participants et la limite pour chaque événement
        $countParticipants = [];
        // Parcourt chaque événement récupéré pour calculer et stocker les informations nécessaires
        foreach($events as $event){
            // Récupère la limite maximale de participants pour l'événement courant
            $limitPlace = $eventManager->limitMax($event->getId());
            // Récupère le nombre actuel de participants à l'événement
            $nombreParticipants = $participantManager->countNumberParticipants($event->getId());
            // Vérifie si le nombre de participants a atteint ou dépassé la limite maximale
            $limitMax = ($nombreParticipants >= $limitPlace);
            // Ajoute un tableau avec l'ID de l'événement, le nombre de participants et un indicateur de limite atteinte
            $countParticipants [] = [
                'id' => $event->getId(),  // ID de l'événement
                'numberParticipants' => $nombreParticipants,  // Nombre actuel de participants
                'limitMax' => $limitMax  // Indicateur de si la limite maximale de participants est atteinte
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
            $limit = filter_input(INPUT_POST, "limits", FILTER_VALIDATE_INT);
            
            if($title && $text && $eventDate && $eventHours && $city && $country && $limit){

                // Vérification si un fichier photo a été téléchargé et si aucune erreur n'a été rencontrée
                if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){

                    // Liste des extensions et types MIME autorisés pour l'image
                    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "webp" => "image/webp");
                    
                    // Récupère le nom du fichier
                    $filename = $_FILES["photo"]["name"];
                    $filetype = $_FILES["photo"]["type"];
                    $filesize = $_FILES["photo"]["size"];

                    // Récupère l'extension du fichier
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                    // Vérifie si l'extension du fichier est dans la liste des extensions autorisées
                    if(!array_key_exists($ext, $allowed)) {
                        SESSION::addFlash('error', "Sélectionner un format de fichier valide !");die; // Si l'extension n'est pas valide, on arrête l'exécution
                    }

                    // Vérifie la taille du fichier, ici on limite à 5Mo
                    $maxsize = 5 * 1024 * 1024;
                    if($filesize > $maxsize) {
                        // Si la taille est trop grande, on arrête le téléchargement
                        SESSION::addFlash('error', "La taille du fichier est supérieure à la limite autorisée !");die; 
                    }

                    // Vérifie que le type MIME du fichier est valide
                    if(in_array($filetype, $allowed)){

                        // Vérifie si un fichier avec le même nom existe déjà sur le serveur
                        if(file_exists("upload/" . $_FILES["photo"]["name"])){

                            // Si le fichier existe déjà, on affiche un message d'erreur
                            SESSION::addFlash('error', "le fichier existe déjà !"); 

                        } else{
                            
                            // Si tout est correct, on déplace le fichier téléchargé vers le dossier "public/upload"
                            move_uploaded_file($_FILES["photo"]["tmp_name"], "public/upload/" . $_FILES["photo"]["name"]);
                            
                            // Si le téléchargement a réussi
                            SESSION::addFlash('success', "Votre fichier a été téléchargé avec succès !"); 
                        }

                    } else{

                        // Si le type MIME n'est pas autorisé
                        SESSION::addFlash('error', "Problème lors du téléchargement. Réessayer !");
                    }

                } else{

                    // Si le téléchargement du fichier a échoué
                    SESSION::addFlash('error', "Erreur !");
                }

                // Créer une nouvelle instance de PublicationManager 
                $eventManager = new EventManager();

                // Récupère le nom de la photo téléchargée
                $photo = $_FILES["photo"]["name"];

                // Récupère l'ID de l'utilisateur actuellement connecté via la session
                $userId = Session::getUser()->getId();

                // Crée un tableau associatif contenant les données à insérer dans la base de données
                $data = ['photo'=>$photo, 'title'=>$title, 'text'=>$text, 'eventDate'=>$eventDate, 'eventHours'=>$eventHours, 'city'=>$city, 'country'=>$country, 'limits'=>$limit, 'user_id'=>$userId];

                // Appelle la méthode 'add' de PublicationManager pour ajouter la nouvelle publication dans la base de données
                $eventManager->add($data);
            
                // Redirige vers la page principale des publications après l'ajout
                $this->redirectTo("event", "index");

                SESSION::addFlash('success', "L'évnèment a bien été ajouté !");
           
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

   // Fonction pour afficher les détails d'un événement, avec l'ID de l'événement passé en paramètre
    public function detailEvents($eventId){

        // Récupère l'ID de l'utilisateur actuellement connecté à partir de la session
        $userId = Session::getUser()->getId();

        // Crée une instance du gestionnaire d'événements
        $eventManager = new EventManager();

        // Crée une instance du gestionnaire de participants
        $participantManager = new ParticipantManager();

        // Crée une instance du gestionnaire de suivi (FollowManager) pour gérer les relations de suivi entre utilisateurs
        $followManager = new FollowManager();

        // Récupère les détails de l'événement à partir de son ID
        $event = $eventManager->findOneById($eventId);

        // Vérifie si l'utilisateur est déjà inscrit à cet événement en utilisant la méthode 'isParticipant'
        if ($isParticipant = $participantManager->isParticipant($eventId, $userId)) {
            // L'action ici peut être laissée vide ou pourrait contenir des traitements supplémentaires si l'utilisateur est déjà inscrit
        }

        // Récupère la capacité maximale de participants pour cet événement
        $limit = $eventManager->limitMax($eventId);

        // Récupère le nombre actuel de participants inscrits à l'événement
        $nombreParticipants = $participantManager->countNumberParticipants($eventId);

        // Vérifie si le nombre de participants a atteint ou dépassé la capacité maximale de l'événement
        $limitMax = ($nombreParticipants >= $limit);

        // Vérifie si l'utilisateur connecté suit déjà l'utilisateur qui a créé l'événement
        $isFollowing = $followManager->following($userId, $event->getUser()->getId());

        // Si l'utilisateur suit déjà l'organisateur de l'événement et que l'action demandée n'est pas déjà 'detailEvents', on redirige vers les détails de l'événement
        if ($isFollowing && $_GET['action'] !== 'detailEvents') {
            // Redirige vers la page des détails de l'événement, ajoutant l'ID de l'événement et l'action 'detailEvents'
            $this->redirectTo("event", "event&action=detailEvents&id=$eventId");
            return; // Arrête l'exécution du code suivant si la redirection a eu lieu
        }

        return [

            "view" => VIEW_DIR."reseauSocial/detailEvent.php",
            "meta_description" => "Détail des évenements",
            "data" => [ 
                "event" => $event,
                "limit" => $limit,
                "nombreParticipants" => $nombreParticipants,
                "limitMax" => $limitMax,
                "isParticipant" => $isParticipant,
                "isFollowing" => $isFollowing

            ]
            
        ];

    } 
    
    public function addParticipant($id) {
        // Récupère l'ID de l'utilisateur actuellement connecté à partir de la session
        $userId = Session::getUser()->getId();
        // Récupère l'ID de l'événement depuis le paramètre 'id' dans l'URL
        $eventId = htmlspecialchars($_GET['id']);
        // Crée une instance du gestionnaire d'événements
        $eventManager = new EventManager();
        // Crée une instance du gestionnaire de participants
        $participantManager = new ParticipantManager();
        // Vérifie si l'utilisateur est déjà inscrit à l'événement en appelant la méthode isParticipant
        if ($isParticipant = $participantManager->isParticipant($eventId, $userId)) {
            // Si l'utilisateur est déjà inscrit, on ajoute un message d'erreur à la session
            SESSION::addFlash('error', "Vous participez déjà à cet évènement !");
            // Puis, on redirige l'utilisateur vers la page des détails de l'événement
            $this->redirectTo("event", "detailEvents&id=$eventId");
        }
        // Récupère la capacité maximale de participants pour l'événement courant
        $limitMax = $eventManager->limitMax($eventId);
        // Récupère le nombre actuel de participants à cet événement
        $nombreParticipants = $participantManager->countNumberParticipants($eventId, $userId);
        // Vérifie si le nombre de participants a atteint ou dépasse la capacité maximale
        if ($nombreParticipants >= $limitMax) {
            // Si l'événement est complet, on ajoute un message d'erreur à la session
            SESSION::addFlash('error', "Cet évènement est complet !");
            // Puis, on redirige l'utilisateur vers la page des détails de l'événement
            $this->redirectTo("event", "detailEvents&id=$eventId");
        }
        // Prépare les données nécessaires à l'ajout de l'utilisateur à la liste des participants
        $data = ['event_id' => $eventId, 'user_id' => $userId];
        // Ajoute l'utilisateur à la liste des participants pour cet événement
        $participantManager->add($data);
        // Ajoute un message de succès à la session pour informer l'utilisateur de son inscription
        SESSION::addFlash('success', "Votre inscription a bien été effectuée !");
        // Enfin, on redirige l'utilisateur vers la page des détails de l'événement
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


