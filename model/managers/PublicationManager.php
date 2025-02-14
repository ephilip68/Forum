<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class PublicationManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Publication";
    protected $tableName = "publication";

    public function __construct(){
        parent::connect();
    }

    //récupère la liste de publications postées par l'utilisateur
    public function findPublicationsByUser($id){

        $sql = "SELECT p.*, u.nickName
        FROM " . $this->tableName . " p 
        INNER JOIN user u ON p.user_id = u.id_user
        WHERE u.id_user = :id";

        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );

    }
    
    // Recherche d'une publication
    public function searchPublications($nickName) {

        $sql = "SELECT *
        FROM " . $this->tableName . " p 
        WHERE p.content LIKE :content";

        // Exécute la requête avec DAO::select et récupère un seul résultat
        $result = DAO::select($sql, ['content' => '%' . $content . '%'], true);
        
        // Retourne vrai si le comptage est supérieur à 0, faux sinon
        return $result;
    }

}