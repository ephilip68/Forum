<?php
namespace Model\Entities;

use App\Entity;
use DateTime;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class FollowPublication extends Entity{

    private $dateFollow;
    private $user_id;
    private $user_id_1;
  

    // chaque entité aura le même constructeur grâce à la méthode hydrate (issue de App\Entity)
    public function __construct($data){  

        $this->hydrate($data); 

    }


    /**
     * Get the value of dateFollow
     */ 
    public function getDateFollow()
    {
        return $this->dateFollow;
    }

    /**
     * Set the value of dateFollow
     *
     * @return  self
     */ 
    public function setDateFollow($dateFollow)
    {
        $this->dateFollow = $dateFollow;

        return $this;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of user_id_1
     */ 
    public function getUser_id_1()
    {
        return $this->user_id_1;
    }

    /**
     * Set the value of user_id_1
     *
     * @return  self
     */ 
    public function setUser_id_1($user_id_1)
    {
        $this->user_id_1 = $user_id_1;

        return $this;
    }
}