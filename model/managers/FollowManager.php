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

    
    public function following($user_id, $user_id_1) {
        
        $sql = "SELECT *
        FROM " . $this->tableName . " f
        WHERE f.user_id  = :user_id
        AND  f.user_id_1 = :user_id_1";
        
        return  $this->getMultipleResults(
            DAO::select($sql, ['user_id' => $user_id, 'user_id_1' => $user_id_1]), 
            $this->className
        );
    }

    public function deleteFollow($user_id, $user_id_1){

        $sql ="DELETE 
        FROM " . $this->tableName . " f
        WHERE f.user_id = :user_id 
        AND f.user_id_1 = :user_id_1";

        return  $this->getMultipleResults(
            DAO::delete($sql, ['user_id' => $user_id, 'user_id_1' => $user_id_1]), 
            $this->className
        );
        
    }

    public function countFollowing($user_id) {

        $sql ="SELECT COUNT(*) AS Nombres_Following 
        FROM " . $this->tableName . " f
        WHERE f.user_id = :user_id ";
       
        return $this->getOneOrNullResult(
            DAO::select($sql, ['user_id' => $user_id], false),
            $this->className
        );

    }

    public function countFollower($user_id_1) {

        $sql ="SELECT COUNT(*) AS Nombres_Followers 
        FROM " . $this->tableName . " f
        WHERE f.user_id_1 = :user_id_1 ";
        
        return $this->getOneOrNullResult(
            DAO::select($sql, ['user_id_1' => $user_id_1], false),
            $this->className
        );

    }

   
}