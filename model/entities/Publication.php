<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class Publication extends Entity{

    private $id;
    private $content;
    private $publicationDate;
    private $photo;
    private $video;
    private $user;

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
     * Get the value of publicationDate
     */ 
    public function getPublicationDate(){

        return $this->publicationDate;

    }

    /**
     * Set the value of publicationDate
     *
     * @return  self
     */ 
    public function setPublicationDate($publicationDate){

        $this->publicationDate = $publicationDate;

        return $this;

    }

    /**
     * Get the value of image
     */ 
    public function getPhoto(){

        return $this->photo;

    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setPhoto($photo){

        $this->photo = $photo;

        return $this;

    }

    /**
     * Get the value of video
     */ 
    public function getVideo(){

        return $this->video;

    }

    /**
     * Set the value of video
     *
     * @return  self
     */ 
    public function setVideo($video){

        $this->video = $video;

        return $this;

    }

    /**
     * Get the value of user_id
     */ 
    public function getUser(){

        return $this->user;

    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUser($user){

        $this->user = $user;

        return $this;
        
    }

    public function getFormattedPublicationDate() {

        if ($this->publicationDate instanceof \DateTime) {
            // Format personnalisé : 'd F Y at H:i'
            return $this->getPublicationDate->format('l jS \of F Y h:i:s A');
        }

        return null; // Si creationDate n'est pas défini ou incorrect
    }

}

