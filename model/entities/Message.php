<?php
namespace Model\Entities;

use App\Entity;
use DateTime;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class Message extends Entity{
    
    private $id;
    private $dateMessage;
    private $messages;
    private $user_id;
    private $user_id_1;
    private $status;
    


    // chaque entité aura le même constructeur grâce à la méthode hydrate (issue de App\Entity)
    public function __construct($data){  

        $this->hydrate($data); 

    }
    
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    
    /**
     * Get the value of dateMessage
     */ 
    public function getDateMessage()
    {
        return $this->dateMessage;
    }

    /**
     * Set the value of dateMessage
     *
     * @return  self
     */ 
    public function setDateMessage($dateMessage)
    {
        $this->dateMessage = $dateMessage;

        return $this;
    }

    /**
     * Get the value of message
     */ 
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Set the value of message
     *
     * @return  self
     */ 
    public function setMessages($messages)
    {
        $this->messages = $messages;

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


    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}