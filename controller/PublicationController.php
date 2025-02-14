<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
use Model\Managers\UserManager;
use Model\Managers\PublicationManager;
use Model\Managers\CommentPublicationManager;
use Model\Managers\LikePublicationManager;
use Model\Managers\CategoryManager;
use Model\Managers\FollowManager;
use Model\Managers\FavoritesManager;
use Model\Managers\TopicManager;
use Model\Managers\EventManager;

class PublicationController extends AbstractController implements ControllerInterface {

    public function index() {

        $id = SESSION::getUser()->getId();
        
        // créer une nouvelle instance de PublicationManager
        $publicationManager = new PublicationManager();

        // créer une nouvelle instance de PublicationManager
        $commentPublicationManager = new commentPublicationManager();

        // créer une nouvelle instance de PublicationManager
        $likePublicationManager = new LikePublicationManager();

        // Créer une nouvelle instance de UserManager 
        $userManager = new UserManager();

        // Créer une nouvelle instance de TopicManager
        $topicManager = new TopicManager();

        // récupére la liste de toutes les publications 
        $publications = iterator_to_array($publicationManager->findAll());

        $commentPublications = '';
        $countLikes = [];
        $userLike = [];
        foreach($publications as $publication) {

            $commentPublications = $commentPublicationManager->findCommentsByPublication($publication->getId()); 
             // Récupérer le nombre de likes
            $countLike = $likePublicationManager->countLikes($publication->getId());
            // Vérifier si l'utilisateur a déjà liké cette publication
            $userLike[$publication->getId()] = $likePublicationManager->userLike($id, $publication->getId());

            $countLikes[] = [

                'id' => $publication->getId(),
                'count' => $countLike
                
            ];
            
        }

        $friends = $userManager->findFriendsByUser($id);

        // Récupére les 2 derniers topics du forum
        $lastTwoTopics = $topicManager->findLastTwoTopics();

        
        return [

            "view" => VIEW_DIR."reseauSocial/homePublications.php",
            "meta_description" => "Liste des publications Réseau Social",
            "data" => [

                "publications" => $publications,
                "commentPublications" => $commentPublications,
                "friends" => $friends,
                "lastTwoTopics" =>$lastTwoTopics,
                "countLikes" =>$countLikes,
                "userLike" =>$userLike
   
            ]
        ];
    }

    public function listPublicationsByUser(){

    }

    public function addPublication(){

        // Vérifie si le formulaire a été soumis 
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            // La fonction filter_input() permet de valider ou nettoyer chaque donnée transmise par le formulaire
            // FILTER_SANITIZE_FULL_SPECIAL_CHARS supprime toute présence de caractères spéciaux et balises HTML
            // Cela est utilisé pour prévenir les attaques XSS (Cross-Site Scripting)
            $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Vérifie si un contenu a été saisi
            if($content){

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
                        SESSION::addFlash('error', "Sélectionner un format de fichier valide !");die; // Si l'extension n'est pas valide, on arrête l'exécution
                    }

                    // Vérifie la taille du fichier, ici on limite à 5Mo
                    $maxsize = 5 * 1024 * 1024;
                    if($filesize > $maxsize) {
                        SESSION::addFlash('error', "La taille du fichier est supérieure à la limite autorisée !");die; // Si la taille est trop grande, on arrête
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
                $publicationManager = new PublicationManager();

                // Récupère le nom de la photo téléchargée
                $photo = $_FILES["photo"]["name"];

                // Récupère l'ID de l'utilisateur actuellement connecté via la session
                $userId = Session::getUser()->getId();

                // Crée un tableau associatif contenant les données à insérer dans la base de données
                $data = ['content'=>$content, 'photo'=>$photo, 'user_id'=>$userId];

                // Appelle la méthode 'add' de PublicationManager pour ajouter la nouvelle publication dans la base de données
                $publicationManager->add($data);

                SESSION::addFlash('success', "Votre publication a été ajoutée !");

                // Redirige vers la page principale des publications après l'ajout
                $this->redirectTo("publication", "index");
           
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

       // Créer une nouvelle instance de PublicationManager 
        $publicationManager = new PublicationManager();

        // Appelle la méthode 'delete' du PublicationManager pour supprimer la publication par son ID
        // L'ID de la publication est passé en paramètre à la méthode delete
        $publicationManager->delete($id);

        SESSION::addFlash('success', "Publication supprimée !");

        // Après la suppression de la publication, on redirige l'utilisateur vers la page principale des publications
        $this->redirectTo("publication", "index");

        return [

            "view" => VIEW_DIR."reseauSocial/homePublications.php",
            "meta_description" => "supprimer publication"

        ];
    }

    public function listAmis($id){

        $id = SESSION::getUser()->getId();

        // Créer une nouvelle instance de UserManager 
        $userManager = new UserManager();

        // Utilise la méthode 'findFriendsByUser' du UserManager pour récupérer la liste des amis d'un utilisateur
        // L'ID de l'utilisateur est passé en paramètre pour filtrer les amis associés à cet utilisateur spécifique
        $friends = $userManager->findFriendsByUser($id);
       
        return [

            "view" => VIEW_DIR."reseauSocial/listAmis.php",
            "meta_description" => "Liste d'amis",
            "data" => [

            "friends" => $friends        
        
            ]

        ];
    }

    public function listProfils($id){

        $currentUserId = SESSION::getUser()->getId();
        $userId = $_GET['id'];

        // Créer une nouvelle instance de UserManager 
        $userManager = new UserManager();

        // Créer une nouvelle instance de EventManager 
        $eventManager = new EventManager();

        // créer une nouvelle instance de PublicationManager
        $publicationManager = new PublicationManager();

        // Créer une nouvelle instance de FollowManager 
        $followManager = new FollowManager();

        $user = $userManager->findOneById($userId);

        // Recherche des amis de l'utilisateur en utilisant la méthode findFriendsByUser du UserManager
        // Cette méthode retourne une liste des amis de l'utilisateur (s'il y en a)
        $friends = $userManager->findFriendsByUser($currentUserId);

        $friendByusers = $userManager->findFriendsByUser($userId);

        // Recherche des publications de l'utilisateur avec la méthode findPublicationsByUser
        // Cette méthode retourne une liste de publications postées par l'utilisateur
        $publications = $publicationManager->findPublicationsByUser($userId);

        // Vérifier si l'utilisateur connecté suit déjà cet utilisateur
        $isFollowing = $followManager->following($currentUserId, $userId);
        
        // Récupére le nombre de personnes suivies par l'utilisateur
        $following = $followManager->countFollowing($userId);
        
        // Récupére le nombre de personnes qui suivent l'utilisateur
        $followers = $followManager->countFollowers($userId);

        // Cette méthode retourne une liste des évènement postées par l'utilisateur
        $events = $eventManager->findEventByUser($userId);

        return [

            "view" => VIEW_DIR."reseauSocial/listProfilFriends.php",
            "meta_description" => "Liste profil d'amis",
            "data" => [

            "user" => $user,
            "friends" => $friends,
            "friendByusers" => $friendByusers,
            "publications" => $publications,
            "isFollowing" => $isFollowing,
            "following" => $following,
            "followers" => $followers,
            "events" => $events       
        
            ]

        ];
    }
    

    public function addFavorites() {

        // Récupérer l'ID de l'utilisateur et de la publication
        $userId = Session::getUser()->getId();
        $publicationId = $_GET['id']; // ID de la publication envoyée par la requête

        // Créer une nouvelle instance de UserManager 
        $favoritesManager = new FavoritesManager();

        // Vérifie si l'utilisateur à déja enregistré la publication
        $isFavorites = $favoritesManager->isFavorites($userId, $publicationId);

        // Si oui, il sera redirigé et reçevra un message d'erreur
        if($isFavorites){

            SESSION::addFlash('error', "Publication déja enregistrée !");

            $this->redirectTo("publication", "index");
            return;

        }

        // Si non, la publication sera ajouté à la BDD
        $data = ['publication_id' => $publicationId, 'user_id' => $userId];

        $favoritesManager->add($data);

        SESSION::addFlash('success', "Publication enregistrée !");

        // Après l'ajout de la publication dans les enregistrements, on redirige l'utilisateur vers la page principale des publications
        $this->redirectTo("publication", "index");

        return [

            "view" => VIEW_DIR."reseauSocial/homePublication.php",
            "meta_description" => "Enregistrer publication"
           
        ];

    }

    public function deleteFavorites($publicationId) {
    
        // Récupérer l'ID de l'utilisateur et de la publication
        $userId = Session::getUser()->getId();

        // Créer une nouvelle instance de UserManager 
        $favoritesManager = new FavoritesManager();

        $favoritesManager->deleteFavorites($userId, $publicationId);

        SESSION::addFlash('success', "Publication supprimée des favoris !");

        // Après la suppression de la publication, on redirige l'utilisateur vers la page principale des enregistrements
        $this->redirectTo("publication", "index.php?ctrl=publication&action=getFavoritesPublications");

        return [

            "view" => VIEW_DIR."reseauSocial/homePublications.php",
            "meta_description" => "Supprimer enregistrements"

        ];
    
    }

    public function getFavoritesPublications() {

        // Récupérer l'ID de l'utilisateur et de la publication
        $userId = Session::getUser()->getId();

        // Créer une nouvelle instance de UserManager 
        $favoritesManager = new FavoritesManager();

        $favorites = $favoritesManager->getFavorites($userId);

        return [

            "view" => VIEW_DIR."reseauSocial/listEnregistrements.php",
            "meta_description" => "Liste des favoris",
            "data" => [

            "favorites" => $favorites        
        
            ]

        ];
    }

    public function search() {

        // Vérifier si la recherche a été soumise avec POST
        if (isset($_POST['submit'])) {

            $search = filter_input(INPUT_POST, "search", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($search) {
                
                $eventManager = new EventManager();  
                $userManager = new UserManager(); 
                $publicationManager = new PublicationManager(); 
                $categoryManager = new CategoryManager(); 
                $topicManager = new TopicManager(); 

                
                $findEvents = $eventManager->searchEvents($search);

                $findFriends = $userManager->searchUsers($search);

                $findPublications = $publicationManager->searchPublications($search);

                $findTopics = $topicManager->searchTopics($search);

                $findCategories = $categoryManager->searchCategories($search);

            }
            return [
                "view" => VIEW_DIR . "reseauSocial/homePublications.php",  
                "meta_description" => "Résultats de recherche",
                "data" => [

                    "search" => $search,
                    "findEvents" => $findEvents,
                    "findFriends" => $findFriends,
                    "findPublications" => $findPublications,
                    "findTopics" => $findTopics,
                    "findCategories" => $findCategories
                    
                ]
            ];
        }

    }

    public function addCommentPublication($id){

        // Vérifie si le formulaire a été soumis via la méthode POST
        if (isset($_POST["submit"])) {
        
        // La fonction filter_input() permet de valider et nettoyer les données transmises via le formulaire
        // Le filtre FILTER_SANITIZE_FULL_SPECIAL_CHARS supprime ou encode les caractères spéciaux et les balises HTML pour prévenir les injections de code (XSS)
        $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // $creationDate = filter_input(INPUT_POST, "creationDate", FILTER_SANITIZE_NUMBER_INT);
        // $closed = filter_input(INPUT_POST, "closed", FILTER_SANITIZE_NUMBER_INT);
        
        // On récupère l'ID de la publication à partir de l'URL, en utilisant $_GET['id']
        $publicationId = $_GET['id'];

        // Récupérer l'utilisateur connecté
        $userId = SESSION::getUser()->getId();

        // Vérifie si le texte du post n'est pas vide après nettoyage
        if ($content) {

            // Crée une instance de CommentPostManager 
            $CommentPublicationManager = new CommentPublicationManager();

            // Prépare les données à insérer dans la base de données
            // On crée un tableau avec le texte du post et l'ID du topic auquel ce post est associé
            $data = ['content' => $content, 'user_id'=>$userId, 'publication_id' => $publicationId];

            $CommentPublicationManager->add($data);

            SESSION::addFlash('success', "Votre commentaire a bien été ajouté !");

            $this->redirectTo("publication", "index");

                return [

                    "view" => VIEW_DIR."reseauSocial/homePublications.php",
                    "meta_description" => "Commenter une publicationq"
 
                ];

            }
        } 
    }

    public function likePublication($id) {

        $publicationId = $_GET['id'];

        $userId = SESSION::getUser()->getId();

        // créer une nouvelle instance de LikeMessage
        $likePublicationManager = new LikePublicationManager();
    
        // Vérifier si l'utilisateur suit déjà cet ami
        $userLike = $likePublicationManager->userLike($userId, $publicationId);
    
        if ($userLike) {
            // Rediriger si déjà liké
            SESSION::addFlash('error', "Vous aimez déja cette publication !");

            $this->redirectTo("publication", "index");
            return;
        }
        
        // Ajouter like dans la base de données
        $data = [
            'publication_id' => $publicationId,
            'user_id' => $userId
        ];
    
        $likePublicationManager->add($data);

        SESSION::addFlash('success', "Like ajouté !");

        $this->redirectTo("publication", "index");
    
        return [

            "view" => VIEW_DIR."reseauSocial/homePublications.php",
            "meta_description" => "Ajouter commentaire"

        ];
    } 

    public function unlikePublication($publicationId) {
    
        // Récupérer l'ID de l'utilisateur et de la publication
        $userId = Session::getUser()->getId();

        // Créer une nouvelle instance de UserManager 
        $likePublicationManager = new likePublicationManager();

        $likePublicationManager->deleteLikes($userId, $publicationId);

        SESSION::addFlash('success', "Like supprimé !");

        // Après la suppression de la publication, on redirige l'utilisateur vers la page principale des enregistrements
        $this->redirectTo("publication", "index");

        return [

            "view" => VIEW_DIR."reseauSocial/homePublications.php",
            "meta_description" => "Supprimer enregistrements"

        ];
    
    }

}

    
