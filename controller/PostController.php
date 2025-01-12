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
use Model\Managers\UnderCommentPostManager;


class PostController extends AbstractController implements ControllerInterface{


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

        $underCommentPostManager = new UnderCommentPostManager();

        // Récupère les informations du topic en utilisant son ID
        $topic = $topicManager->findOneById($id);

        // Récupère tous les posts associés à ce topic en utilisant l'ID du topic
        $post = $postManager->findPostsByTopic($id);
        
        // Récupère les informations du topic en utilisant son ID
        $comments = $commentPostManager->findCommentsByPost($post->getId());

        $underComments = $underCommentPostManager->findUnderCommentByCommentPost($post->getId());
        
        // Récupérer le nombre de likes
        $countLike = $likeMessageManager->countLikes($post->getId());

        // Vérifier si l'utilisateur a déjà liké ce topic
        $userLike = $likeMessageManager->userLike($userId, $id);
        
        // Nombre de vue du topic, la méthode topicViews incrémente les vues du topic par son Id
        // Si l'utilisateur connecté est celui qui à crée le topic les vues ne s'incrémenteront pas
        if($userId != $topic->getUser()->getId()){

            $topicManager->topicViews($id);

        }

        return [

            "view" => VIEW_DIR."forum/listPosts.php",
            "meta_description" => "Liste des posts du forum",
            "data" => [

                "topic" => $topic,
                "post" => $post,
                "comments" => $comments,
                "countLike" => $countLike,
                "userLike" => $userLike,
                "underComments" => $underComments

            ]   
        ];
    }

    public function addCommentPost($id){

        // Vérifie si le formulaire a été soumis via la méthode POST
        if (isset($_POST["submit"])) {
        
        // La fonction filter_input() permet de valider et nettoyer les données transmises via le formulaire
        // Le filtre FILTER_SANITIZE_FULL_SPECIAL_CHARS supprime ou encode les caractères spéciaux et les balises HTML pour prévenir les injections de code (XSS)
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

            $CommentPostManager->add($data);

            $this->redirectTo("post", "listPostsByTopic&id=$topic");

                return [

                    "view" => VIEW_DIR."forum/listPosts.php",
                    "meta_description" => "Liste des posts du forum"
 
                ];

            }
        }    
    }

    public function addUnderComment($id){

        // Vérifie si le formulaire a été soumis via la méthode POST
        if (isset($_POST["submit"])) {
        
        // La fonction filter_input() permet de valider et nettoyer les données transmises via le formulaire
        // Le filtre FILTER_SANITIZE_FULL_SPECIAL_CHARS supprime ou encode les caractères spéciaux et les balises HTML pour prévenir les injections de code (XSS)
        $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        // On récupère l'ID du topic à partir de l'URL, en utilisant $_GET['id']
        $commentId = $_GET['id'];

        // Récupérer l'utilisateur connecté
        $userId = SESSION::getUser()->getId();

        // Vérifie si le texte du post n'est pas vide après nettoyage
        if ($text) {

            // Créer une instance de UnderCommentPostManager 
            $underCommentManager = new UnderCommentPostManager();

            // Prépare les données à insérer dans la base de données
            // On crée un tableau avec le texte du post et l'ID du topic auquel ce post est associé
            $data = ['text' => $text, 'user_id'=>$userId, 'comment_id' => $commentId];

            
            $underCommentManager->add($data);

            $this->redirectTo("post", "listPostsByTopic&id=$topicId");

                return [

                    "view" => VIEW_DIR."forum/listPosts.php",
                    "meta_description" => "Liste des posts du forum"
 
                ];

            }
        }    
    }
}