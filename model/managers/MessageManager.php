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

    // Récupérer les messages d'un utilisateur (entrant et sortant)
    public function getMessages($user_id) {
        
        $sql = "SELECT m.*, u.nickName FROM messages m
                INNER JOIN user u ON m.user_id = u.id_user
                WHERE m.user_id_1 = :user_id OR m.user_id = :user_id
                ORDER BY m.dateMessage DESC";
    
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['user_id' => $user_id]), 
            $this->className
        );

    }


    // Marquer les messages comme lus
    public function markAsRead($message_id) {
        $stmt = $this->pdo->prepare('UPDATE messages SET is_read = 1 WHERE id = :id');
        $stmt->bindParam(':id', $message_id);
        return $stmt->execute();
    }

    
}