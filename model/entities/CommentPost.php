<?php
namespace Model\Entities;

use App\Entity;
use DateTime;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class CommentPost extends Entity{

    private $id;
    private $text;
    private $commentDate;
    private $post;
    private $user;


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
     * Get the value of text
     */ 
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the value of text
     *
     * @return  self
     */ 
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the value of commentDate
     */ 
    public function getCommentDate()
    {
        return $this->commentDate;
    }

    /**
     * Set the value of commentDate
     *
     * @return  self
     */ 
    public function setCommentDate($commentDate)
    {
        $this->commentDate = $commentDate;

        return $this;
    }

    /**
     * Get the value of post_id
     */ 
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set the value of post_id
     *
     * @return  self
     */ 
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

}
