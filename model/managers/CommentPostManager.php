<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class CommentPostManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\CommentPost";
    protected $tableName = "commentpost";

    public function __construct(){
        parent::connect();
    }

     // récupérer tous les commentaires d'une catégorie spécifique (par son id)
     public function findCommentsByPost($id){

        $sql = "SELECT * 
        FROM ".$this->tableName." 
        WHERE post_id = :id";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }
}
