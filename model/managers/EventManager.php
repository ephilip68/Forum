<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class EventManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Event";
    protected $tableName = "event";

    public function __construct(){
        parent::connect();
    }

    public function findEventByUser($id){

        $sql = "SELECT e.id_event, e.creationDate, e.photo, e.title, e.text, e.eventDate, e.eventHours, e.city, e.country, e.user_id, u.nickName
        FROM " . $this->tableName . " e 
        INNER JOIN user u ON e.user_id = u.id_user
        WHERE u.id_user = :id";

        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );

    }

    // Recherche d'un utilisateur
    public function searchEvents($title) {

        $sql = "SELECT *
        FROM " . $this->tableName . " e
        WHERE e.title LIKE :title";

        // Exécute la requête avec DAO::select et récupère un seul résultat
        $result = DAO::select($sql, ['title' => '%' . $title . '%'], true);
        
        // Retourne vrai si le comptage est supérieur à 0, faux sinon
        return $result;
    }

    // Récupère tous les évènements avec pagination
    public function findAllEvents($start, $limit) {

        $sql = "SELECT * 
                FROM " . $this->tableName . " e 
                ORDER BY e.creationDate DESC 
                LIMIT $start, $limit"; 
        
        return $this->getMultipleResults(
            DAO::select($sql),
            $this->className
        );
    }

    public function totalEvents() {

        $sql = "SELECT COUNT(*) 
        FROM " . $this->tableName . " e ";
        
        $result = DAO::select($sql);
    
        return (int) $result[0]['COUNT(*)'];
    }

    // Vérifier si l'évènement est complet
    public function limitMax($id) {
        
        $sql = "SELECT e.limit 
        FROM " . $this->tableName . " e
        WHERE e.id_event = :id";

        // Exécute la requête avec DAO::select et récupère un seul résultat
        $result = DAO::select($sql, ['id' => $id], false);
    
        return $result ['limit'] ?? 0;
    }


}
