<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class CommentPublicationManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\CommentPublication";
    protected $tableName = "comment_publication";

    public function __construct(){
        parent::connect();
    }

    // récupérer tous les commentaires d'une publication spécifique (par son id)
    public function findCommentsByPublication($id){

        $sql = "SELECT c.id_comment, c.content, c.commentDate, c.publication_id, c.user_id, u.avatar, u.nickName
        FROM ".$this->tableName." c
        INNER JOIN user u ON c.user_id = u.id_user
        WHERE c.publication_id = :id";
       
        // Exécute la requête avec DAO::select et récupère un seul résultat
        $result = DAO::select($sql, ['id' => $id], true);

        // Retourne vrai si le comptage est supérieur à 0, faux sinon
        return $result;
    }

    public function anonymizeCommentsByUser($id){

        $sql = " UPDATE ".$this->tableName." c
        SET c.user_id = NULL
        WHERE c.user_id = :userId";

        $result = DAO::update($sql, ["userId" => $id]);

        return $result;

    }
    
}