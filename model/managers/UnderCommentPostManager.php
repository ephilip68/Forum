<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class UnderCommentPostManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\UnderCommentPost";
    protected $tableName = "under_comment_post";

    public function __construct(){
        parent::connect();
    }


    // Méthode pour récupérer les sous-commentaires d'un commentaire
    public function findUnderComment($id) {
    
        // Requête pour récupérer les sous-commentaires
        $sql = "SELECT u.text, u.commentDate, u.user_id, u.comment_id, s.avatar, s.nickName
        FROM ".$this->tableName." u
        INNER JOIN comment_post c ON u.comment_id = c.id_comment
        LEFT JOIN user s ON u.user_id = s.id_user
        WHERE c.id_comment = :id";

        // Exécute la requête avec DAO::select et récupère un seul résultat
        $result = DAO::select($sql, ['id' => $id], true);

        // Retourne vrai si le comptage est supérieur à 0, faux sinon
        return $result;
    }

    public function countUnderComment($id) {

        $sql = "SELECT COUNT(*) 
        FROM " . $this->tableName . " u
        WHERE u.comment_id = :id";
    
        // la requête renvoie un seul résultat ou `null` si rien n'est trouvé.
        return $this->getSingleScalarResult(
            DAO::select($sql, ['id' => $id], false),  
            $this->className  
        );
    }

    public function anonymizeUnderCommentsByUser($id){

        $sql = " UPDATE ".$this->tableName." u
        SET u.user_id = NULL
        WHERE u.user_id = :userId";

        $result = DAO::update($sql, ["userId" => $id]);

        return $result;
    }
}