<?php
namespace Controller;


use IntlDateFormatter;
use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;
use Model\Managers\LikeMessageManager;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\CommentPostManager;

class ForumController extends AbstractController implements ControllerInterface{

    public function index() {

        // Créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();

        // créer une nouvelle instance de TopicManager
        $topicManager = new TopicManager();

         // créer une nouvelle instance de UserManager
        $userManager = new UserManager;

        // Récupérer la liste de toutes les catégories grâce à la méthode findAll()
        // Si findAll() retourne un générateur, il faut le convertir en tableau
        $categories = iterator_to_array($categoryManager->findAll());

        // Crée un tableau pour stocker les catégories avec le nombre de topics
        $countTopic = [];

        // Pour chaque catégorie, récupérer le nombre de topics associés
        foreach ($categories as $category) {

            // Récupère le nombre de topics pour chaque catégorie
            $topicCount = $categoryManager->countTopicByCategory($category->getId());

            // Récupère la date du dernier topic pour cette catégorie
            $lastTopic = $topicManager->lastTopicDateByCategory($category->getId());

            $lastTopicDate = '';

            if ($lastTopic) {
                
                $forumController = new ForumController();

                $lastTopicDate = $forumController->getFormattedDate($lastTopic['creationDate']);

            }

            // Récupérer l'image de profil du dernier utilisateur
            $lastUserAvatar = '';

            if ($lastTopic) {

                $lastUserAvatar = $userManager->getProfileAvatar($lastTopic['user_id']);

            }

            // Ajoute les détails du topic dans le tableau
            $countTopic[] = [
                
                'id_category' => $category->getId(),
                'name' => $category->getName(),
                'COUNT(*)' => $topicCount,
                'last_title' => $lastTopic ? $lastTopic['title'] : 'Aucun sujet',
                'last_date' => $lastTopicDate ? $lastTopicDate : 'Aucune activité',
                'last_user' => $lastTopic ? $lastTopic['user_id'] : '',
                'last_avatar' => $lastUserAvatar ? $lastUserAvatar ['avatar'] : ''

            ];
            // var_dump($lastUserAvatar['avatar']);die;
        }
        
        // Envoie les données à la vue
        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [

                "categories" => $categories,  
                "countTopic" => $countTopic,
                   
            ]
        ];
    }

    public function listTopicsByCategory($id) {

        // créer une nouvelle instance de TopicManager
        $topicManager = new TopicManager();
    
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();

        // Appelle la méthode `findOneById` du CategoryManager pour obtenir les informations sur la catégorie à partir de l'ID passé en argument ($id). Cela va récupérer une catégorie spécifique de la base de données.
        $category = $categoryManager->findOneById($id);
    
        // Appelle la méthode `findTopicsByCategory` du TopicManager pour récupérer tous les topics qui sont associés à cette catégorie spécifique.
        $topics = $topicManager->findTopicsByCategory($id);

        // Incrémentez les vues du topic chaque fois que l'on consulte un topic
        $topicManager->topicViews($id);

        // Récupérez le topic et le nombre de vues
        $topicViews = $topicManager->getTopicViews($id);  // Supposez que cette méthode existe pour récupérer un topic
        $views = $topicManager->topicViews($topicViews);  // Récupère le nombre de vues

        
        return [
            "view" => VIEW_DIR . "forum/listTopics.php", 
            "meta_description" => "Liste des topics par catégorie : " . $category, 
            "data" => [
                "category" => $category, 
                "topics" => $topics,
                "views" => $views
                
                
            ]
        ];
    }

    public function getFormattedDate($creationDate) {

        // Récupérer le fuseau horaire de la France (Europe/Paris)
        $timezone = new \DateTimeZone('Europe/Paris');  
        
        // Récupérer la date actuelle avec le bon fuseau horaire
        $now = new \DateTime('now', $timezone);  
    
        // Récupérer la date de publication avec le bon fuseau horaire
        $creationDates = new \DateTime($creationDate, $timezone);
        
        // Calculer la différence de temps
        $diff = $now->diff($creationDates);

        // Si la publication vient d'être mise en ligne (moins de 1 minute)
        if ($diff->s < 60 && $diff->i === 0 && $diff->h === 0 && $diff->d === 0 && $diff->m === 0 && $diff->y === 0) {
            return "À l'instant"; 
        }

        // Si la publication est dans moins de 1 minute mais plus d'instant
        if ($diff->i === 1 && $diff->h === 0 && $diff->d === 0 && $diff->m === 0 && $diff->y === 0) {
            return "Il y a 1 minute"; 
        }

        // Moins de 1 heure : Affiche "Il y a X minute(s)"
        if ($diff->h === 0 && $diff->d === 0 && $diff->y === 0 && $diff->m === 0) {
            return "Il y a " . $diff->i . " minute" . ($diff->i > 1 ? "s" : "");
        }

        // Moins de 24 heures : Affiche "Il y a X heure(s)"
        if ($diff->d === 0 && $diff->y === 0 && $diff->m === 0) {
            return "Il y a " . $diff->h . " heure" . ($diff->h > 1 ? "s" : "");
        }

        // Hier : Affiche "Hier à Xh"
        if ($diff->d === 1) {
            return "Hier à " . $creationDates->format('H\hi'); // Format : Hier à 10h30
        }

        // De 1 à 7 jours : (ex. : "Lundi 5 janvier à 11h").
        if ($diff->d > 1 && $diff->d <= 7) {
            $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
            $formatter->setPattern("d MMMM, HH'h'mm"); 
            return $formatter->format($creationDates);
        }

        // Plus de 7 jours : (ex. : "5 janvier 2024").
        if ($diff->d > 7) {
            $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
            $formatter->setPattern('d MMMM yyyy'); 
            return $formatter->format($creationDates);
        }
    }


    public function addCategory(){

        // Vérifie si le formulaire a été soumis via la méthode POST
        if (isset($_POST["submit"])) {
            
            // La fonction filter_input() permet de valider et nettoyer les données transmises via le formulaire.
            // Le filtre FILTER_SANITIZE_FULL_SPECIAL_CHARS supprime les caractères spéciaux et les balises HTML, les encodant pour éviter des problèmes de sécurité (XSS).
            // Ici, on nettoie le champ 'title' du formulaire (nom de la catégorie).
            $name = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            // Vérifie que le nom de la catégorie (après nettoyage) n'est pas vide
            if ($name) {

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
                $categoryManager = new CategoryManager();

                // Récupère le nom de la photo téléchargée
                $photo = $_FILES["photo"]["name"];

                // Crée un tableau associatif contenant les données à insérer dans la base de données
                $data = ['name'=>$name, 'photo'=>$photo];

                // Appelle la méthode 'add' de PublicationManager pour ajouter la nouvelle publication dans la base de données
                $categoryManager->add($data);

                // Redirige vers la page principale des publications après l'ajout
                $this->redirectTo("forum", "index");

                
                return [

                    "view" => VIEW_DIR."forum/listCategories.php",
                    "meta_description" => "Page ajouter categotie",
                    "data" => [

                        "name" => $name,
                        "photo" => $photo
                        
        
                    ]
                    
                ];
            }
        }    
    }

    public function deleteCategory($id){

        // // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();

        // Appelle la méthode 'delete' du CategoryManager pour supprimer la catégorie spécifiée par son ID
        // Cette méthode supprime la catégorie de la base de données en fonction de l'ID passé en paramètre
        $categoryManager->delete($id);

        // Appelle la méthode redirectTo pour rediriger l'utilisateur vers une autre page
        $this->redirectTo($ctrl = "forum", $action = "index");;

        return [

            "view" => VIEW_DIR."reseauSocial/listCategories.php",
            "meta_description" => "supprimer categorie"
        ];
    }

    public function addTopicToCategory($id){
        
        // Vérifie si le formulaire a été soumis via la méthode POST
        // Cela signifie que l'utilisateur a rempli le formulaire pour ajouter un topic à la catégorie
        if (isset($_POST["submit"])) {
        
            // La fonction filter_input() permet de valider et nettoyer les données transmises via le formulaire
            // Le filtre FILTER_SANITIZE_FULL_SPECIAL_CHARS supprime ou encode les caractères spéciaux et balises HTML
            // Cela empêche l'injection de code HTML ou JavaScript (XSS)
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);  // Récupère le titre du topic et le nettoie
            $message = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);  // Récupère le texte du message initial et le nettoie
            // $creationDate = filter_input(INPUT_POST, "creationDate", FILTER_SANITIZE_NUMBER_INT);
            // $closed = filter_input(INPUT_POST, "closed", FILTER_SANITIZE_NUMBER_INT);
            
            // Récupère l'ID de la catégorie à partir de l'URL via $_GET['id']
            // Cela permet de savoir à quelle catégorie on ajoute ce topic
            $category = $_GET['id'];

            // Récupérer l'utilisateur connecté
            $user_id = SESSION::getUser()->getId();

            // Vérifie si le titre et le message du topic ne sont pas vides après nettoyage
            if ($title && $message) {
                
                // // créer une nouvelle instance de TopicManager
                $topicManager = new TopicManager();

                // Prépare les données pour l'ajout du topic dans la base de données
                // On crée un tableau associatif avec le titre du topic et l'ID de la catégorie à laquelle il appartient
                $dataTopic = ['title' => $title, 'user_id' => $user_id, 'category_id' => $category];

                // Appelle la méthode 'add' du TopicManager pour ajouter un nouveau topic dans la base de données
                // La méthode 'add' retourne probablement l'ID du topic ajouté
                $topics = $topicManager->add($dataTopic);

                // // créer une nouvelle instance de PostManager
                $postManager = new PostManager();

                // Prépare les données pour l'ajout du message initial du topic (le premier post)
                // On crée un tableau associatif avec le texte du message et l'ID du topic auquel il appartient
                $dataPost = ['text' => $message, 'user_id' => $user_id, 'topic_id' => $topics];  // On utilise l'ID du topic retourné par l'ajout du topic

                // Appelle la méthode 'add' du PostManager pour ajouter un premier post dans la base de données pour ce topic
                $posts = $postManager->add($dataPost);

                $this->redirectTo("forum", "index.php?ctrl=forum&action=listTopicsByCategory&id=$category");
    
               
                return [

                    "view" => VIEW_DIR."forum/listTopics.php",
                    "meta_description" => "Ajouter topic",
                    "data" => [
                        "category" => $category, 
                        "topics" => $topics,
                        
                    ]
                ];
            }
        }    
    }


    public function addPostToTopic($id){

        // Vérifie si le formulaire a été soumis via la méthode POST
        // Cela signifie que l'utilisateur a rempli le formulaire pour ajouter un post au topic
        if (isset($_POST["submit"])) {
        
        // La fonction filter_input() permet de valider et nettoyer les données transmises via le formulaire
        // Le filtre FILTER_SANITIZE_FULL_SPECIAL_CHARS supprime ou encode les caractères spéciaux et les balises HTML pour prévenir les injections de code (XSS)
        // Ici, on nettoie le texte du post (le contenu que l'utilisateur veut publier)
        $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // $creationDate = filter_input(INPUT_POST, "creationDate", FILTER_SANITIZE_NUMBER_INT);
        // $closed = filter_input(INPUT_POST, "closed", FILTER_SANITIZE_NUMBER_INT);
        
        // On récupère l'ID du topic à partir de l'URL, en utilisant $_GET['id']
        // Cela permet d'ajouter le post au topic spécifique
        $topicId = $_GET['id'];

         // Récupérer l'utilisateur connecté
         $userId = SESSION::getUser()->getId();

        // Vérifie si le texte du post n'est pas vide après nettoyage
        if ($text) {

            // Crée une instance de PostManager 
            $postManager = new PostManager();

            // Prépare les données à insérer dans la base de données
            // On crée un tableau avec le texte du post et l'ID du topic auquel ce post est associé
            $data = ['text' => $text, 'user_id'=>$userId, 'topic_id' => $topicId];

            // Appelle la méthode 'add' du PostManager pour ajouter le nouveau post dans la base de données
            $postManager->add($data);

            $this->redirectTo("forum", "listPostsByTopic&id=$topicId");

                return [

                    "view" => VIEW_DIR."forum/listPosts.php",
                    "meta_description" => "Liste des posts du forum"
 
                ];

            }
        }    
    }



    public function likePost($id) {

        $postId = $_GET['id'];

        $userId = SESSION::getUser()->getId();

        // créer une nouvelle instance de LikeMessage
        $likeMessageManager = new LikeMessageManager();
    
        // Vérifier si l'utilisateur suit déjà cet ami
        $userLike = $likeMessageManager->userLike($userId, $postId);
    
        if ($userLike) {
            // Rediriger si déjà suivi
            echo "Vous aimez déjà ce post.";
            $this->redirectTo("forum", "listPostsByTopic&id=$postId");
            return;
        }
        
    
        // Ajouter like dans la base de données
        $data = [
            'post_id' => $postId,
            'user_id' => $userId
        ];
    
        $likeMessageManager->add($data);

        $this->redirectTo("forum", "listPostsByTopic&id=$postId");
    
        return [

            "view" => VIEW_DIR."forum/listPosts.php",
            "meta_description" => "Liste des posts du forum"

        ];
    }
}