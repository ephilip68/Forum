<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;
use Model\Managers\LikePostManager;
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

        $userManager = new UserManager();
        
        // créer une nouvelle instance de TopicManager
        $topicManager = new TopicManager();

        // Crée une instance de CommentPostManager 
        $commentPostManager = new CommentPostManager();

        // Créer une nouvelle instance de LikeMessage
        $likePostManager = new LikePostManager();

        $underCommentPostManager = new UnderCommentPostManager();

        // Récupère les informations du topic en utilisant son ID
        $topic = $topicManager->findOneById($id);

        // Récupère tous les posts associés à ce topic en utilisant l'ID du topic
        $post = $postManager->findPostsByTopic($id);
        
        // Récupère les informations du topic en utilisant son ID
        $comments = $commentPostManager->findCommentsByPost($post->getId());

        $countComments = [];
        $underComments = '';
        if(!empty($comments)){
            foreach ($comments as $comment) {

                // Récupère les sous commentaire d'un commentaire spécifique en passant par l'ID comment
                $underComments = $underCommentPostManager->findUnderComment($comment['id_comment']);

                $countUnderComments = $underCommentPostManager->countUnderComment($comment['id_comment']);

                $countComments[] = [

                    'id' => $comment['id_comment'],
                    'count' => $countUnderComments
                    
                ];
            }
        }

        // Récupérer le nombre de likes
        $countLike = $likePostManager->countLikes($post->getId());

        // Vérifier si l'utilisateur a déjà liké ce topic
        $userLike = $likePostManager->userLike($userId, $id);
        
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
                "underComments" => $underComments,
                // "userUnderComment" => $userUnderComment,
                "countComments" => $countComments

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

            SESSION::addFlash('success', "Votre commentaire a bien été ajouté !");

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

            SESSION::addFlash('success', "Votre commentaire a bien été ajouté !");

            $this->redirectTo("post", "listPostsByTopic&id=$topicId");

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
        $likePostManager = new LikePostManager();
    
        // Vérifier si l'utilisateur suit déjà cet ami
        $userLike = $likePostManager->userLike($userId, $postId);
    
        if ($userLike) {
            // Rediriger si déjà suivi
            SESSION::addFlash('error', "Vous aimez déja ce post !");

            $this->redirectTo("post", "listPostsByTopic&id=$postId");
            return;
        }
        
        // Ajouter like dans la base de données
        $data = [
            'post_id' => $postId,
            'user_id' => $userId
        ];
    
        $likePostManager->add($data);

        SESSION::addFlash('success', "Like ajouté !");

        $this->redirectTo("post", "listPostsByTopic&id=$postId");
    
        return [

            "view" => VIEW_DIR."forum/listPosts.php",
            "meta_description" => "Liste des posts du forum"

        ];
    }
}