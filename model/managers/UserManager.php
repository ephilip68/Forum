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

    // récupére un utilisateur en fonction de son email
    public function findOneByEmail($email){
        
        $sql = "SELECT * 
        FROM " . $this->tableName . " u 
        WHERE u.email = :email";
    
        // la requête renvoie un seul résultat ou `null` si rien n'est trouvé.
        return $this->getOneOrNullResult(
            DAO::select($sql, ['email' => $email], false), 
            $this->className  
        );
    }
    
    //trouve les amis de l'utilisateur en fonction de son ID
    public function findFriendsByUser($id){

        $sql = "SELECT u.id_user, u.nickName 
        FROM " . $this->tableName . " u 
        INNER JOIN follow f ON u.id_user = f.user_id_1
        WHERE f.user_id = :id";

        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );

    }

    public function updateProfilPhoto($userId, $file){

        $sql = "UPDATE ". $this->tableName . " u 
        SET u.avatar = :file WHERE u.id_user = :userId";

        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['file' => $file, 'userId' => $userId]), 
            $this->className
        );

    }


    // Met à jour les informations de l'utilisateur
    public function updateUser($id, $nickName, $email, $password) {

        $sql = "UPDATE ". $this->tableName . " u  
        SET u.id = :id, u.nickName = :nickName, u.email = :email, u.password = :password 
        WHERE id = :id";

        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id , 'nickName' => $nickName, 'email'=> $email , 'password' => $password]), 
            $this->className
        );
       
    }

        //trouve les amis de l'utilisateur en fonction de son ID
        public function getProfileAvatar($id){

            $sql = "SELECT u.avatar
            FROM " . $this->tableName . " u 
            WHERE u.id_user = :id";
    
             // Exécute la requête avec DAO::select et récupère un seul résultat
             $result = DAO::select($sql, ['id' => $id], false);
            
             // Retourne vrai si le comptage est supérieur à 0, faux sinon
             return $result;
    
        }

    

}