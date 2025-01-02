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

    // // Récupérer tous les événements à venir
    // public function comingEvents($id){

    //     $sql = "SELECT * 
    //     FROM ".$this->tableName." e 
    //     WHERE e.id_event = :id 
    //     ORDER BY eventDate ASC";

    //     // la requête renvoie plusieurs enregistrements --> getMultipleResults
    //     return  $this->getMultipleResults(
    //         DAO::select($sql, ['id' => $id]), 
    //         $this->className
    //     );
    // }

}
