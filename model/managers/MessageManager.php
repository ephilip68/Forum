<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class MessageManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Message";
    protected $tableName = "message";

    public function __construct(){
        parent::connect();
    }

    public function messagesBetweenUsers($user_id, $recipientId) {

        $sql = "SELECT m.*, u.nickName, u.avatar
        FROM " . $this->tableName . " m
        INNER JOIN user u ON m.user_id = u.id_user  
        WHERE m.user_id = :user_id AND m.user_id_1 = :recipientId
        OR m.user_id = :recipientId AND m.user_id_1 = :user_id
        ORDER BY m.dateMessage ASC";
        
       // Exécute la requête avec DAO::select et récupère un seul résultat
       $result = DAO::select($sql, ['user_id' => $user_id, 'recipientId' => $recipientId ], true);
    
       // Retourne vrai si le comptage est supérieur à 0, faux sinon
       return $result;
    }

    // Méthode pour récupérer le nombre de messages non lus
    public function unreadMessagesCount($user_id) {
        // SQL pour récupérer le nombre de messages non lus pour l'utilisateur
        $sql = "SELECT COUNT(*)
        FROM " . $this->tableName . " m
        WHERE m.user_id_1 = :user_id AND m.status = 'unread'";

        return $this->getSingleScalarResult(
            DAO::select($sql, ['user_id' => $user_id], false),  
            $this->className  
        );
    }

    // Marquer les messages comme lus
    public function markAsRead($user_id, $recipientId) {
        
        $sql = "UPDATE " . $this->tableName . " m
        SET status = 'read'
        WHERE user_id = :recipientId AND  user_id_1 = :user_id
        AND status = 'unread'";

         // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['user_id' => $user_id , 'recipientId' => $recipientId]), 
            $this->className
        );
    }

    public function getConversations($user_id){

        $sql =" SELECT u.id_user, u.nickName, u.avatar, m.user_id_1
        FROM " . $this->tableName . " m
        INNER JOIN user u ON u.id_user = m.user_id_1 AND m.user_id = :user_id
        OR m.user_id = u.id_user AND m.user_id_1 = :user_id
        WHERE m.user_id = :user_id OR m.user_id_1 = :user_id
        GROUP BY m.user_id";

        // Exécute la requête avec DAO::select et récupère un seul résultat
       $result = DAO::select($sql, ['user_id' => $user_id], true);
    
       // Retourne vrai si le comptage est supérieur à 0, faux sinon
       return $result;

    }


}