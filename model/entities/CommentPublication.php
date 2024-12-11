<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class CommentPublication extends Entity{

    private $id;
    private $content;
    private $commentDate;
    private $publication_id;
    private $user_id;


    // chaque entité aura le même constructeur grâce à la méthode hydrate (issue de App\Entity)
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
     * Get the value of commentDate
     */ 
    public function getCommentDate(){

        return $this->commentDate;

    }

    /**
     * Set the value of commentDate
     *
     * @return  self
     */ 
    public function setCommentDate($commentDate){

        $this->commentDate = $commentDate;

        return $this;

    }

    /**
     * Get the value of content
     */ 
    public function getContent(){

        return $this->content;

    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content){

        $this->content = $content;

        return $this;

    }

    /**
     * Get the value of publication_id
     */ 
    public function getPublication_id(){

        return $this->publication_id;

    }

    /**
     * Set the value of publication_id
     *
     * @return  self
     */ 
    public function setPublication_id($publication_id){

        $this->publication_id = $publication_id;

        return $this;

    }

    /**
     * Get the value of user_id
     */ 
    public function getUser_id(){

        return $this->user_id;

    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUser_id($user_id){

        $this->user_id = $user_id;

        return $this;

    }
}