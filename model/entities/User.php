<?php
namespace Model\Entities;

use App\Entity;
use dateTime;
use IntlDateFormatter;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class User extends Entity{

    private $id;
    private $nickName;
    private $password;
    private $dateInscription;
    private $avatar;
    private $email;
    private $role;
    private $isBanned;

    public function __construct($data){   

        $this->hydrate($data);   

    }

    /**
     * Get the value of id
     */ 
    public function getId(){

        return $this->id;

    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id){

        $this->id = $id;
        return $this;

    }

    /**
     * Get the value of nickName
     */ 
    public function getNickName(){

        return $this->nickName;

    }

    /**
     * Set the value of nickName
     *
     * @return  self
     */ 
    public function setNickName($nickName){

        $this->nickName = $nickName;

        return $this;

    }

    public function __toString(){

        return $this->nickName;

    }

    /**
     * Get the value of password
     */ 
    public function getPassword(){

        return $this->password;

    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password){

        $this->password = $password;

        return $this;

    }

    /**
     * Get the value of dateInscription
     */ 
    public function getDateInscription(){

        return $this->dateInscription;

    }

    /**
     * Set the value of dateInscription
     *
     * @return  self
     */ 
    public function setDateInscription($dateInscription){

        $this->dateInscription = $dateInscription;

        return $this;

    }

    /**
     * Get the value of avatar
     */ 
    public function getAvatar(){

        return $this->avatar;

    }

    /**
     * Set the value of avatar
     *
     * @return  self
     */ 
    public function setAvatar($avatar){

        $this->avatar = $avatar;

        return $this;

    }

  
    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
        return $this;  
    }
    
    /**
     * Get the value of role
     */ 
    public function getRole(){
        
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role){

        $this->role = $role;

        return $this;
    }

    public function hasRole($role){

        if($this->role == $role){

            return true;

        }

        return false;
    }
    
    /**
     * Get the value of isBanned
     */ 
    public function getIsBanned()
    {
        return $this->isBanned;
    }

    /**
     * Set the value of isBanned
     *
     * @return  self
     */ 
    public function setIsBanned($isBanned)
    {
        $this->isBanned = $isBanned;

        return $this;
    }
    
    /**
     * Format publication date based on time difference or full date
     *
     * @return string
    */
    public function getFormattedDateInscription() {
        $now = new DateTime();
        $dateInscription = new DateTime($this->dateInscription);
        $diff = $now->diff($dateInscription);

        // Utilisation d'IntlDateFormatter pour formater la date en français
        $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        $formatter->setPattern('d MMMM yyyy'); // Format : Lundi 5 janvier 2025
        return $formatter->format($dateInscription);
    }



}