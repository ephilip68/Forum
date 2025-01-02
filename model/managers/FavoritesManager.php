<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class FavoritesManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Favorites";
    protected $tableName = "favorites";

    public function __construct(){
        parent::connect();
    }

    // Vérifier si une publication est déjà enregistrée
    public function isFavorites($userId, $publicationId) {

        $sql = "SELECT COUNT(*) 
        FROM " . $this->tableName . " f
        WHERE f.user_id = :user_id 
        AND f.publication_id = :publication_id";
        
        // Exécute la requête avec DAO::select et récupère un seul résultat
        $result = DAO::select($sql, ['user_id' => $userId, 'publication_id' => $publicationId], false);

        // Retourne vrai si le comptage est supérieur à 0, faux sinon
        return $result ? $result['COUNT(*)'] > 0 : false;

    }

    // Récupérer les publications enregistrées d'un utilisateur
    public function getFavorites($userId) {
        $sql = "SELECT * 
        FROM publication p
        INNER JOIN " . $this->tableName . " f 
        ON p.id_publication = f.publication_id
        WHERE f.user_id = :user_id";
       
         // la requête renvoie plusieurs enregistrements --> getMultipleResults
         return  $this->getMultipleResults(
            DAO::select($sql, ['user_id' => $userId]), 
            $this->className
        );
    }

    public function deleteFavorites($userId, $publicationId) {

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

