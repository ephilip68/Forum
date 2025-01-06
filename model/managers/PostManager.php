<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class PostManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Post";
    protected $tableName = "post";

    public function __construct(){
        parent::connect();
    }

    // récupérer tous les topics d'une catégorie spécifique (par son id)
    public function findPostsByTopic($id) {

        $sql = "SELECT * 
        FROM ".$this->tableName."  
        WHERE topic_id = :id";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
       // la requête renvoie un seul résultat ou `null` si rien n'est trouvé.
       return $this->getOneOrNullResult(
        DAO::select($sql, ['id' => $id], false), 
        $this->className  
    );
        
    }
}