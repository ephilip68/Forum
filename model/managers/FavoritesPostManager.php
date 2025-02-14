<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class FavoritesPostManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\FavoritesPost";
    protected $tableName = "favorites_post";

    public function __construct(){
        parent::connect();
    }

    // Vérifier si un post est déjà enregistrée
    public function isFavorites($userId, $postId) {

        $sql = "SELECT COUNT(*) 
        FROM " . $this->tableName . " f
        WHERE f.user_id = :user_id 
        AND f.post_id = :post_id";
        
        // Exécute la requête avec DAO::select et récupère un seul résultat
        $result = DAO::select($sql, ['user_id' => $userId, 'post_id' => $postId], false);

        // Retourne vrai si le comptage est supérieur à 0, faux sinon
        return $result ? $result['COUNT(*)'] > 0 : false;

    }

    // Récupérer les posts enregistrées d'un utilisateur
    public function getFavorites($userId) {
        $sql = "SELECT f.*, t.title 
        FROM post p
        INNER JOIN " . $this->tableName . " f ON p.id_post = f.post_id
        INNER JOIN topic t on p.topic_id = t.id_topic
        WHERE f.user_id = :user_id";
       
         // la requête renvoie plusieurs enregistrements --> getMultipleResults
         return  $this->getMultipleResults(
            DAO::select($sql, ['user_id' => $userId]), 
            $this->className
        );
    }

    public function deleteFavorites($userId, $postId) {

        $sql = "DELETE 
        FROM " . $this->tableName . " f
        WHERE f.user_id = :user_id 
        AND f.post_id = :post_id";
    
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return $this->getMultipleResults(
            DAO::delete($sql, ['user_id' => $userId, 'post_id' => $postId]),  
            $this->className 
        );

    }
}