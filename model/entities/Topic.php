<?php
namespace Model\Entities;

use App\Entity;
use DateTime;
use IntlDateFormatter;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class Topic extends Entity{

    private $id;
    private $title;
    private $user;
    private $category;
    private $creationDate;
    private $closed;

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

    /**
     * Get the value of category_id
     */ 
    public function getCategory()
    {
        return $this->category;
    }
    
    /**
     * Set the value of category_id
     *
     * @return  self
     */ 
    public function setCategory($category)
    {
        $this->category = $category;
        
        return $this;
    }

    /**
     * Get the value of creationDate
     */ 
    public function getCreationDate()
    {
        return $this->creationDate;
    }
    
    /**
     * Set the value of creationDate
     *
     * @return  self
     */ 
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        
        return $this;
    }
    
    /**
     * Get the value of closed
     */ 
    public function getClosed()
    {
        return $this->closed;
    }
    
    /**
     * Set the value of closed
     *
     * @return  self
     */ 
    public function setClosed($closed)
    {
        $this->closed = $closed;
        
        return $this;
    }

    public function __toString(){
        return $this->title;
    }

    public function getFormattedDate() {

        // Récupérer le fuseau horaire de la France (Europe/Paris)
        $timezone = new \DateTimeZone('Europe/Paris');  
        
        // Récupérer la date actuelle avec le bon fuseau horaire
        $now = new \DateTime('now', $timezone);  
    
        // Récupérer la date de publication avec le bon fuseau horaire
        $creationDate = new \DateTime($this->creationDate, $timezone);
        
        // Calculer la différence de temps
        $diff = $now->diff($creationDate);

        // Si la publication vient d'être mise en ligne (moins de 1 minute)
        if ($diff->s < 60 && $diff->i === 0 && $diff->h === 0 && $diff->d === 0 && $diff->m === 0 && $diff->y === 0) {
            return "À l'instant"; 
        }

        // Si la publication est dans moins de 1 minute mais plus d'instant
        if ($diff->i === 1 && $diff->h === 0 && $diff->d === 0 && $diff->m === 0 && $diff->y === 0) {
            return "Il y a 1 minute"; 
        }

        // Moins de 1 heure : Affiche "Il y a X minute(s)"
        if ($diff->h === 0 && $diff->d === 0 && $diff->y === 0 && $diff->m === 0) {
            return "Il y a " . $diff->i . " minute" . ($diff->i > 1 ? "s" : "");
        }

        // Moins de 24 heures : Affiche "Il y a X heure(s)"
        if ($diff->d === 0 && $diff->y === 0 && $diff->m === 0) {
            return "Il y a " . $diff->h . " heure" . ($diff->h > 1 ? "s" : "");
        }

        // Hier : Affiche "Hier à Xh"
        if ($diff->d === 1) {
            return "Hier à " . $creationDate->format('H\hi'); // Format : Hier à 10h30
        }

        // De 1 à 7 jours : (ex. : "Lundi 5 janvier à 11h").
        if ($diff->d > 1 && $diff->d <= 7) {
            $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
            $formatter->setPattern("d MMMM, HH'h'mm"); 
            return $formatter->format($creationDate);
        }

        // Plus de 7 jours : (ex. : "5 janvier 2024").
        if ($diff->d > 7) {
            $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
            $formatter->setPattern('d MMMM yyyy'); 
            return $formatter->format($creationDate);
        }
    }
}