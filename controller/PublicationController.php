<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
use Model\Managers\UserManager;
use Model\Managers\PublicationManager;
use Model\Managers\FollowManager;

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
            $publicationManager = new PublicationManager();

            // Récupère le nom de la photo téléchargée
            $photo = $_FILES["photo"]["name"];

            // Récupère l'ID de l'utilisateur actuellement connecté via la session
            $userId = Session::getUser()->getId();

            // Crée un tableau associatif contenant les données à insérer dans la base de données
            $data = ['content'=>$content, 'photo'=>$photo, 'user_id'=>$userId];

            // Appelle la méthode 'add' de PublicationManager pour ajouter la nouvelle publication dans la base de données
            $publicationManager->add($data);

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

        // Après la suppression de la publication, on redirige l'utilisateur vers la page principale des publications
        $this->redirectTo("publication", "index");

        return [

            "view" => VIEW_DIR."reseauSocial/homePublications.php",
            "meta_description" => "supprimer publication"

        ];
    }

    public function listAmis($id){

        // Créer une nouvelle instance de UserManager 
        $userManager = new UserManager();

        // Utilise la méthode 'findFriendsByUser' du UserManager pour récupérer la liste des amis d'un utilisateur
        // L'ID de l'utilisateur est passé en paramètre pour filtrer les amis associés à cet utilisateur spécifique
        $friends = $userManager->findFriendsByUser($id);
       
        return [

            "view" => VIEW_DIR."reseauSocial/listAmis.php",
            "meta_description" => "List d'amis",
            "data" => [

            "friends" => $friends        
        
            ]

        ];
    }



    

    

}

    
