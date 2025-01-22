<?php
namespace Model\Entities;

use App\Entity;
use DateTime;
use IntlDateFormatter;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class Event extends Entity{

    private $id;
    private $creationDate;
    private $photo;
    private $title;
    private $text;
    private $eventDate;
    private $eventHours;
    private $city;
    private $country;
    private $user;
    private $limit;



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
     * Get the value of creationDate
     */ 
    public function getCreationDate(){

        return $this->creationDate;

    }

    /**
     * Set the value of creationDate
     *
     * @return  self
     */ 
    public function setCreationDate($creationDate){

        $this->creationDate = $creationDate;

        return $this;

    }

    /**
     * Get the value of photo
     */ 
    public function getPhoto(){

        return $this->photo;

    }

    /**
     * Set the value of photo
     *
     * @return  self
     */ 
    public function setPhoto($photo){

        $this->photo = $photo;

        return $this;

    }

    /**
     * Get the value of title
     */ 
    public function getTitle(){

        return $this->title;

    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title){

        $this->title = $title;

        return $this;

    }

    /**
     * Get the value of text
     */ 
    public function getText(){

        return $this->text;

    }

    /**
     * Set the value of text
     *
     * @return  self
     */ 
    public function setText($text){

        $this->text = $text;

        return $this;

    }

    /**
     * Get the value of eventDate
     */ 
    public function getEventDate(){

        return $this->eventDate;

    }

    /**
     * Set the value of eventDate
     *
     * @return  self
     */ 
    public function setEventDate($eventDate){

        $this->eventDate = $eventDate;

        return $this;

    }
    
    /**
     * Get the value of eventHours
     */ 
    public function getEventHours(){

        return $this->eventHours;

    }

    /**
     * Set the value of eventHours
     *
     * @return  self
     */ 
    public function setEventHours($eventHours){

        // Si $eventHours est une chaîne, la convertir en objet DateTime
        if (is_string($eventHours)) {
            $eventHours = new \DateTime($eventHours); // Créer un objet DateTime à partir de la chaîne
        }

        // Formater la date pour afficher uniquement l'heure et les minutes
        $this->eventHours = $eventHours->format('H:i');

        return $this;

    }
    
    /**
     * Get the value of city
     */ 
    public function getCity(){

        return $this->city;

    }

    /**
     * Set the value of city
     *
     * @return  self
     */ 
    public function setCity($city){

        $this->city = $city;

        return $this;

    }

    /**
     * Get the value of country
     */ 
    public function getCountry(){

        return $this->country;

    }

    /**
     * Set the value of country
     *
     * @return  self
     */ 
    public function setCountry($country){

        $this->country = $country;

        return $this;

    }
    
    /**
     * Get the value of user
     */ 
    public function getUser(){

        return $this->user;

    }
    
    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user){

        $this->user = $user;
    
        return $this;

    }
    
    /**
     * Get the value of limit
     */ 
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Set the value of limit
     *
     * @return  self
     */ 
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }
    
    public function getFormattedDate() {

        // Récupérer le fuseau horaire de la France (Europe/Paris)
        $timezone = new \DateTimeZone('Europe/Paris');  
        
        // Récupérer la date actuelle avec le bon fuseau horaire
        $now = new \DateTime('now', $timezone);  
    
        // Récupérer la date de publication avec le bon fuseau horaire
        $eventDate = new \DateTime($this->eventDate, $timezone);  
        
        // Calculer la différence de temps
        $diff = $now->diff($eventDate);

        $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        $formatter->setPattern('d MMMM yyyy'); 
        return $formatter->format($eventDate);
       
    }

}





