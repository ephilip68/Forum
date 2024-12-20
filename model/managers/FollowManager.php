<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class FollowManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Follow";
    protected $tableName = "follow";

    public function __construct(){
        parent::connect();
    }

   
}