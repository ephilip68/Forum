<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class ParticipantManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Participant";
    protected $tableName = "participant";

    public function __construct(){
        parent::connect();
    }

    // Vérifie si le participant est déja inscrit à l'évènement
    public function isParticipant($eventId, $userId) {

        $sql = "SELECT COUNT(*) 
        FROM " . $this->tableName . " p 
        WHERE p.event_id = :event_id 
        AND p.user_id = :user_id";
        
       // Exécute la requête avec DAO::select et récupère un seul résultat
       $result = DAO::select($sql, ['event_id' => $eventId, 'user_id' => $userId], false);
       
       // Retourne vrai si le comptage est supérieur à 0, faux sinon
       return $result ? $result['COUNT(*)'] > 0 : false;

    }

    // Compte le nombre d'utilisateur participant à un évènement
    public function countNumberParticipants($id) {

        $sql = "SELECT COUNT(*)  
        FROM " . $this->tableName . " p 
        WHERE p.event_id = :id";
        
        return $this->getSingleScalarResult(
            DAO::select($sql, ['id' => $id], false),  
            $this->className  
        );
    }

    public function deleteParticipant($event_id, $user_id) {

        $sql = "DELETE
        FROM " . $this->tableName . " p
        WHERE p.event_id = :event_id 
        AND p.user_id = :user_id";
    
        return $this->getMultipleResults(
            DAO::delete($sql, ['event_id' => $event_id, 'user_id' => $user_id]),  
            $this->className 
        );

    }


}