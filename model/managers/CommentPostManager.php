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
        FROM ".$this->tableName." p
        WHERE p.post_id = :id";
       
        // Exécute la requête avec DAO::select et récupère un seul résultat
        $result = DAO::select($sql, ['id' => $id], true);

        // Retourne vrai si le comptage est supérieur à 0, faux sinon
        return $result;
    }

    
}
