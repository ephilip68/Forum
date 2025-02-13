<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class LikePublicationManager extends Manager {

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\LikePublication";
    protected $tableName = "like_publication";

    public function __construct(){
        parent::connect();
    }

    // Fonction pour récupérer le nombre de likes d'une publication
    public function countLikes($id) {

        $sql = "SELECT COUNT(*) 
        FROM " . $this->tableName . " l
        WHERE l.publication_id = :id";
    
        // la requête renvoie un seul résultat ou `null` si rien n'est trouvé.
        return $this->getSingleScalarResult(
            DAO::select($sql, ['id' => $id], false),  
            $this->className  
        );
    }

    // Fonction pour vérifier si un utilisateur a déjà liké une publication
    public function userLike($userId, $postId) {

        $sql = "SELECT COUNT(*) 
        FROM " . $this->tableName . " l
        WHERE l.user_id = :userId 
        AND l.publication_id = :postId";

        // Exécute la requête avec DAO::select et récupère un seul résultat
        $result = DAO::select($sql, ['userId' => $userId, 'postId' => $postId], false);
    
        // Retourne vrai si le comptage est supérieur à 0, faux sinon
        return $result ? $result['COUNT(*)'] > 0 : false;
    }

    public function deleteLikes($userId, $publicationId) {

        $sql = "DELETE 
        FROM " . $this->tableName . " f
        WHERE f.user_id = :user_id 
        AND f.publication_id = :publication_id";
    
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return $this->getMultipleResults(
            DAO::delete($sql, ['user_id' => $userId, 'publication_id' => $publicationId]),  
            $this->className 
        );

    }

}