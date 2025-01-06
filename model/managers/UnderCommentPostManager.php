<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class UnderCommentPostManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\UnderCommentPost";
    protected $tableName = "undercommentpost";

    public function __construct(){
        parent::connect();
    }


    // Méthode pour récupérer les sous-commentaires d'un commentaire
    public function findUnderCommentByCommentPost($id) {
    
        // Requête pour récupérer les sous-commentaires
        $sql = "SELECT * 
        FROM ".$this->tableName." u
        WHERE u.comment_id = :id";

        // Exécute la requête avec DAO::select et récupère un seul résultat
        $result = DAO::select($sql, ['id' => $id], true);

        // Retourne vrai si le comptage est supérieur à 0, faux sinon
        return $result;
    }
}