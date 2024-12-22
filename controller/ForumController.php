<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;

class ForumController extends AbstractController implements ControllerInterface{

    public function index() {
        
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();

        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categoryManager->findAll();

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [

            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [

                "categories" => $categories

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
    
        
        return [
            "view" => VIEW_DIR . "forum/listTopics.php", 
            "meta_description" => "Liste des topics par catégorie : " . $category, 
            "data" => [
                "category" => $category, 
                "topics" => $topics 
            ]
        ];
    }

    public function listPostsByTopic($id) {
        
        // créer une nouvelle instance de PostManager
        $postManager = new PostManager();
        
        // créer une nouvelle instance de TopicManager
        $topicManager = new TopicManager();

        // Récupère les informations du topic en utilisant son ID
        $topic = $topicManager->findOneById($id);

        // Récupère tous les posts associés à ce topic en utilisant l'ID du topic
        $posts = $postManager->findPostsByTopic($id);

        // le controller communique avec la vue "listPosts" (view) pour lui envoyer la liste des Posts (data)
        return [

            "view" => VIEW_DIR."forum/listPosts.php",
            "meta_description" => "Liste des posts du forum",
            "data" => [

                "topic" => $topic,
                "posts" => $posts

            ]   
        ];
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

                // créer une nouvelle instance de CategoryManager
                $categoryManager = new CategoryManager();

                // Prépare les données à insérer dans la base de données 'name' correspond à la valeur nettoyée du champ 'title'
                $data = ['name' => $name];

                // Appelle la méthode 'add' du CategoryManager pour ajouter une nouvelle catégorie dans la base de données
                $categoryManager->add($data);
                
                return [

                    "view" => VIEW_DIR."forum/listCategories.php",
                    "meta_description" => "Page ajouter categotie",
                    
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
        $categoryId = $_GET['id'];

            // Vérifie si le titre et le message du topic ne sont pas vides après nettoyage
            if ($title && $message) {
                
                // // créer une nouvelle instance de TopicManager
                $topicManager = new TopicManager();

                // Prépare les données pour l'ajout du topic dans la base de données
                // On crée un tableau associatif avec le titre du topic et l'ID de la catégorie à laquelle il appartient
                $dataTopic = ['title' => $title, 'category_id' => $categoryId];

                // Appelle la méthode 'add' du TopicManager pour ajouter un nouveau topic dans la base de données
                // La méthode 'add' retourne probablement l'ID du topic ajouté
                $topics = $topicManager->add($dataTopic);

                // // créer une nouvelle instance de PostManager
                $postManager = new PostManager();

                // Prépare les données pour l'ajout du message initial du topic (le premier post)
                // On crée un tableau associatif avec le texte du message et l'ID du topic auquel il appartient
                $dataPost = ['text' => $message, 'topic_id' => $topics];  // On utilise l'ID du topic retourné par l'ajout du topic

                // Appelle la méthode 'add' du PostManager pour ajouter un premier post dans la base de données pour ce topic
                $posts = $postManager->add($dataPost);
               
                return [

                    "view" => VIEW_DIR."reseauSocial/listCategories.php",
                    "meta_description" => "Ajouter topic"
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

        // Vérifie si le texte du post n'est pas vide après nettoyage
        if ($text) {

            // Crée une instance de PostManager 
            $postManager = new PostManager();

            // Prépare les données à insérer dans la base de données
            // On crée un tableau avec le texte du post et l'ID du topic auquel ce post est associé
            $data = ['text' => $text, 'topic_id' => $topicId];

            // Appelle la méthode 'add' du PostManager pour ajouter le nouveau post dans la base de données
            $postManager->add($data);

                return [

                    "view" => VIEW_DIR."forum/listPostsByTopic&id.php",
                    "meta_description" => "Liste des posts du forum",
 
                ];

            }
        }    
    }
}