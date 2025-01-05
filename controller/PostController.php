<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;
use Model\Managers\LikeMessageManager;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\CommentPostManager;

class PostController extends AbstractController implements ControllerInterface{

    public function index(){

        // Envoie les données à la vue
        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                    
            ]
        ];
    }

    public function listPostsByTopic($id) {

        $userId = SESSION::getUser()->getId();
        
        // créer une nouvelle instance de PostManager
        $postManager = new PostManager();
        
        // créer une nouvelle instance de TopicManager
        $topicManager = new TopicManager();

        // Crée une instance de CommentPostManager 
        $commentPostManager = new CommentPostManager();

        // Créer une nouvelle instance de LikeMessage
        $likeMessageManager = new LikeMessageManager();

        // Récupère les informations du topic en utilisant son ID
        $topic = $topicManager->findOneById($id);

        // Récupère tous les posts associés à ce topic en utilisant l'ID du topic
        $posts = $postManager->findPostsByTopic($id);
        
        // Récupère les informations du topic en utilisant son ID
        $comments = $commentPostManager->findCommentsByPost($id);
        // var_dump($comments);die;
        // Récupérer le nombre de likes
        $countLike = $likeMessageManager->countLikes($id);


        // Vérifier si l'utilisateur a déjà liké ce topic
        $userLike = $likeMessageManager->userLike($userId, $id);

        // le controller communique avec la vue "listPosts" (view) pour lui envoyer la liste des Posts (data)
        return [

            "view" => VIEW_DIR."forum/listPosts.php",
            "meta_description" => "Liste des posts du forum",
            "data" => [

                "topic" => $topic,
                "posts" => $posts,
                "comments" => $comments,
                "countLike" => $countLike,
                "userLike" => $userLike

            ]   
        ];
    }

     public function addCommentPost($id){

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
        $postId = $_GET['id'];

        // Récupérer l'utilisateur connecté
        $userId = SESSION::getUser()->getId();

        // Vérifie si le texte du post n'est pas vide après nettoyage
        if ($text) {

            // Crée une instance de CommentPostManager 
            $CommentPostManager = new CommentPostManager();

            // Prépare les données à insérer dans la base de données
            // On crée un tableau avec le texte du post et l'ID du topic auquel ce post est associé
            $data = ['text' => $text, 'user_id'=>$userId, 'post_id' => $postId];

            // Appelle la méthode 'add' du PostManager pour ajouter le nouveau post dans la base de données
            $CommentPostManager->add($data);

            $this->redirectTo("forum", "listPostsByTopic&id=$topicId");

                return [

                    "view" => VIEW_DIR."forum/listPosts.php",
                    "meta_description" => "Liste des posts du forum"
 
                ];

            }
        }    
    }
}