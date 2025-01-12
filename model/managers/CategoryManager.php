<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class CategoryManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Category";
    protected $tableName = "category";

    public function __construct(){
        parent::connect();
    }

    public function countTopicByCategory($category_id) {
        // La requête SQL pour compter les topics d'une catégorie donnée
        $sql = "SELECT COUNT(*)
                FROM ".$this->tableName." c
                INNER JOIN topic t ON c.id_category = t.category_id AND closed = 0
                WHERE t.category_id = :category_id ";
    
        
        // la requête renvoie un seul résultat ou `null` si rien n'est trouvé.
        return $this->getSingleScalarResult(
            DAO::select($sql, ['category_id' => $category_id], false),  
            $this->className  
        );
    }

    // Recherche d'un utilisateur
    public function searchCategories($name) {

        $sql = "SELECT *
        FROM " . $this->tableName . " c
        WHERE c.name LIKE :name";

        // Exécute la requête avec DAO::select et récupère un seul résultat
        $result = DAO::select($sql, ['name' => '%' . $name . '%'], true);
        
        // Retourne vrai si le comptage est supérieur à 0, faux sinon
        return $result;
    }


}    