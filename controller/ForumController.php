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
        $category = $categoryManager->findAll();

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [

            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [

                "category" => $category

            ]
        ];
    }

    public function listTopicsByCategory($id) {

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id);

        return [

            "view" => VIEW_DIR."forum/listTopics.php",
            "meta_description" => "Liste des topics par catégorie : ".$category,
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

        // récupére juste l'id Topic
        $topic = $topicManager->findOneById($id);
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

        if(isset($_POST["submit"])){
            
            // La fonction filter_input() permet de valider ou nettoyer chaque donnée transmise par le formulaire en utilisant divers filtres
            // FILTER_SANITIZA_STRING supprime une chaîne de caractère de toute présence de caractères spéciaux et balise HTML potentielle ou encodes
            $name = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if($name){

                $categoryManager = new CategoryManager();

                $data = ['name'=>$name];

                $categoryManager->add($data);

                return [

                    "view" => VIEW_DIR."forum/listCategories.php",
                    "meta_description" => "Page ajouter categotie",
                    
                ];
            }
        }    
    }

    public function addTopicToCategory($id){
        
        if(isset($_POST["submit"])){
            
            // La fonction filter_input() permet de valider ou nettoyer chaque donnée transmise par le formulaire en utilisant divers filtres
            // FILTER_SANITIZA_STRING supprime une chaîne de caractère de toute présence de caractères spéciaux et balise HTML potentielle ou encodes
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $message = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $categoryId = $_GET['id'];
            // $creationDate = filter_input(INPUT_POST, "creationDate", FILTER_SANITIZE_NUMBER_INT);
            // $closed = filter_input(INPUT_POST, "closed", FILTER_SANITIZE_NUMBER_INT);

            if($title && $message){

                $topicManager = new TopicManager();
                

                $dataTopic = ['title'=>$title, 'category_id'=>$categoryId];
                
                
                $topics = $topicManager->add($dataTopic);
                // var_dump($topics);
                // die;
             
                $postManager = new PostManager();

                $dataPost = ['text' => $message, 'topic_id' => $topics];
                // var_dump($dataPost);
                // die;

                $posts = $postManager->add($dataPost);
                // var_dump($posts);
                // die;
            }
        }    
    }

    public function addPostToTopic($id){

        if(isset($_POST["submit"])){
            
            // La fonction filter_input() permet de valider ou nettoyer chaque donnée transmise par le formulaire en utilisant divers filtres
            // FILTER_SANITIZA_STRING supprime une chaîne de caractère de toute présence de caractères spéciaux et balise HTML potentielle ou encodes
            $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // $message = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $topicId = $_GET['id'];
            // $creationDate = filter_input(INPUT_POST, "creationDate", FILTER_SANITIZE_NUMBER_INT);
            // $closed = filter_input(INPUT_POST, "closed", FILTER_SANITIZE_NUMBER_INT);

            if($text){

                $postManager = new PostManager();

                $data = ['text'=>$text, 'topic_id'=> $topicId];

                $postManager->add($data);

                return [

                    "view" => VIEW_DIR."forum/listPostsByTopic&id.php",
                    "meta_description" => "Liste des posts du forum",
 
                ];

            }
        }    
    }
}