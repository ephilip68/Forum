<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class NewslettersManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Newsletters";
    protected $tableName = "newsletters";

    public function __construct(){
        parent::connect();
    }

    // Vérifier si un utilisateur est déjà abonné
    public function isSubscribed($email) {

        $sql = "SELECT COUNT(*) 
        FROM ".$this->tableName." n 
        WHERE n.email = :email";

        // Exécute la requête avec DAO::select et récupère un seul résultat
        $result = DAO::select($sql, ['email' => $email], false);
    
        // Retourne vrai si le comptage est supérieur à 0, faux sinon
        return $result ? $result['COUNT(*)'] > 0 : false;
    }

   
}
