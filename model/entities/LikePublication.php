<?php
namespace Model\Entities;

use App\Entity;
use DateTime;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class LikePublication extends Entity {

    private $publication;
    private $user;

     // chaque entité aura le même constructeur grâce à la méthode hydrate (issue de App\Entity)
     public function __construct($data){  

        $this->hydrate($data); 

    }
    
    /**
     * Get the value of publication
     */ 
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * Set the value of publication
     *
     * @return  self
     */ 
    public function setPublication($publication)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}