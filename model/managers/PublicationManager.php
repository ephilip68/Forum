<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class PublicationManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Publication";
    protected $tableName = "publication";

    public function __construct(){
        parent::connect();
    }

    // // récupérer tous les topics d'une catégorie spécifique (par son id)
    // public function findPostsByTopic($id) {

    //     $sql = "SELECT * 
    //             FROM ".$this->tableName."  
    //             WHERE topic_id = :id";
       
    //     // la requête renvoie plusieurs enregistrements --> getMultipleResults
    //     return  $this->getMultipleResults(
    //         DAO::select($sql, ['id' => $id]), 
    //         $this->className
    //     );
        
    // }
}