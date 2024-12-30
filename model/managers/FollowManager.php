<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class FollowManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Follow";
    protected $tableName = "follow";

    public function __construct(){
        parent::connect();
    }

    // récupère les id afin de pouvoir vérifier si les utilisateur se suivent déja
    public function following($user_id, $friend_id) {
        $sql = "SELECT COUNT(*) 
                FROM " . $this->tableName . " f
                WHERE f.user_id = :user_id
                AND f.user_id_1 = :friend_id";
    
        // Exécute la requête avec DAO::select et récupère un seul résultat
        $result = DAO::select($sql, ['user_id' => $user_id, 'friend_id' => $friend_id], false);
    
        // Retourne vrai si le comptage est supérieur à 0, faux sinon
        return $result ? $result['COUNT(*)'] > 0 : false;

    }

    // supprime colonne de la table Follow en fonction de l'ID de l'utilisateur et de l'ID de la personne qu'il suit
    public function deleteFollow($user_id, $friend_id) {

        $sql = "DELETE 
        FROM " . $this->tableName . " f
        WHERE f.user_id = :user_id 
        AND f.user_id_1 = :friend_id";
    
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return $this->getMultipleResults(
            DAO::delete($sql, ['user_id' => $user_id, 'friend_id' => $friend_id]),  
            $this->className 
        );

    }

    //compte le nombre de follow d'un unique utilisateur
    public function countFollowing($user_id) {
    
        $sql = "SELECT COUNT(*) 
        FROM " . $this->tableName . " f
        WHERE f.user_id = :user_id";
    
        // la requête renvoie un seul résultat ou `null` si rien n'est trouvé.
        return $this->getSingleScalarResult(
            DAO::select($sql, ['user_id' => $user_id], false),  
            $this->className  
        );

    }

    
    //compte le nombre de followers d'un unique utilisateur
    public function countFollowers($user_id_1) {
        
        $sql = "SELECT COUNT(*)  
        FROM " . $this->tableName . " f
        WHERE f.user_id_1 = :user_id_1";
        
        // la requête renvoie un seul résultat ou `null` si rien n'est trouvé.
        return $this->getSingleScalarResult(
            DAO::select($sql, ['user_id_1' => $user_id_1], false), 
            $this->className 
            );

    }

    // Recherche les utilisateurs suivis et les followers d'un utilisateur
    public function searchFollowedAndFollowers($searchQuery, $user_id) {

        $searchQuery = '%' . $searchQuery . '%';  // Ajouter des jokers pour une recherche "contains"

        // Recherche les suivis
        $sql = "SELECT u.id_user, u.nickName, 'following' AS relationship
        FROM user u
        INNER JOIN follow f ON f.user_id_1 = u.id_user
        WHERE f.user_id = :user_id
        AND u.nickName LIKE :searchQuery
        UNION
        -- Recherche les followers
        SELECT u.id_user, u.nickName, 'follower' AS relationship
        FROM user u
        INNER JOIN follow f ON f.user_id = u.id_user
        WHERE f.user_id_1 = :user_id
        AND u.nickName LIKE :searchQuery";

        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return $this->getMultipleResults(
            DAO::select($sql, ['user_id' => $user_id, 'searchQuery' => $searchQuery]),  
            $this->className 
            );
    }
            
}