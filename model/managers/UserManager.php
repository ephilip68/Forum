<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class UserManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\User";
    protected $tableName = "user";

    public function __construct(){
        parent::connect();
    }

    public function findOneByEmail($email){
        $sql = "SELECT * 
                FROM " . $this->tableName . " u 
                WHERE u.email = :email";
 
        return $this->getOneOrNullResult(
            DAO::select($sql, ['email' => $email], false),
            $this->className
        );
    }

    public function findFriendsByUser($id){

        $sql = "SELECT u.id_user, u.nickName 
                FROM " . $this->tableName . " u 
                INNER JOIN follow f ON u.id_user = f.user_id_1
                WHERE f.user_id = :id";

        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );

    }

}