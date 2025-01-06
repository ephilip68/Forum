<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class TopicManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";

    public function __construct(){
        parent::connect();
    }

    // Récupérer tous les topics d'une catégorie spécifique
    public function findTopicsByCategory($id){

        $sql = "SELECT * 
        FROM ".$this->tableName." 
        WHERE category_id = :id";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }

    // Récupérer la date du dernier topic publié dans cette catégorie
    public function lastTopicDateByCategory($category_id) {
        
        $sql = "SELECT t.title, t.user_id, t.creationDate
                FROM ".$this->tableName." t
                WHERE t.category_id = :category_id 
                AND t.closed = 0
                ORDER BY t.creationDate DESC
                LIMIT 1";
    
        // Exécute la requête avec DAO::select et récupère un seul résultat
        $result = DAO::select($sql, ['category_id' => $category_id], false);
    
        // Retourne vrai si le comptage est supérieur à 0, faux sinon
        return $result;
    }

    public function getTopicViews($id) {
        // Requête pour récupérer le nombre de vues d'un topic
        $sql = "SELECT t.views 
        FROM ".$this->tableName." t
        WHERE t.id_topic = :id";
        
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );;
    }
    
    // Incrémente le nombre de vues pour un topic donné
    public function topicViews($id) {
        $sql = "UPDATE ".$this->tableName." t
        SET views = views + 1 
        WHERE t.id_topic = :id";

        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }

    
}


