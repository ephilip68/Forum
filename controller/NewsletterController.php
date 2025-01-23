<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
use Model\Managers\NewsletterManager;
use Model\Managers\UserManager;

class NewsletterController extends AbstractController implements ControllerInterface {

    public function index(){
        
        return [

            "view" => VIEW_DIR."newsletters/listNewsletters.php",
            "meta_description" => "liste des abonnés"

        ];
    }

    public function subscribe() {
        
        if(isset($_POST["submit"])){

            // Récupérer les données du formulaire
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

            $newsletterManager = new NewsletterManager();
            
            // Vérifier si l'email est déjà abonné
            if ($newsletterManager->isSubscribed($email)) {
                
                SESSION::addFlash('error', "Cet email est déjà utilisé !");

                $this->redirectTo("newsletter", "index");
           
            }

            // Vérifier si l'utilisateur est connecté
            $userId = Session::getUser()->getId(); 

            $data = ['email'=>$email, 'user_id'=>$userId];

            // Ajouter l'abonné à la newsletter
            $newsletters = $newsletterManager->add($data);

            if ($newsletters) {

                $newsletterController = new NewsletterController();

                // Envoi de la newsletter après l'inscription
                $newsletterController->sendEmail($to, $email, $subject, $message, $headers);

                SESSION::addFlash('success', "Vous êtes maintenant inscrit à la newsletter !");

            } else {

                SESSION::addFlash('error', "Une erreur est survenue, veuillez réessayer !"); 

            }
        } else {

            SESSION::addFlash('error', "L'adresse email est requise !");

        }
            
        $this->redirectTo("newsletter", "index");

        return [

            "view" => VIEW_DIR."newsletters/listNewsletters.php",
            "meta_description" => "Abonnement"

        ];
        
    }

    
    public function sendNewsletter() {

        $newsletterManager = new NewsletterManager();

        // Récupérer tous les abonnés avec leurs emails
        $subscribers = $newsletterManager->getAllSubscribers();

        $to = 'sportLink.newsletters@gmail.com';
        $subject = 'Notre dernière newsletter';
        $message = '<h1>Bonjour, voici notre dernière newsletter !</h1><p>Contenu de la newsletter...</p>';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From: sportLink.newsletters@gmail.com" . "\r\n";
        $headers .= "Reply-To: sportLink.newsletters@gmail.com" . "\r\n";
        
        // Envoyer l'email à chaque abonné
        foreach ($subscribers as $subscriber) {

           $email = $subscriber->getEmail();

            $sent = mail($to, $email, $subject, $message, $headers);

            if ($sent) {
                SESSION::addFlash('success', "E-mail envoyé à : " . $email . "<br>"); 
            } else {
                SESSION::addFlash('error', "Erreur lors de l'envoi à : " . $email . "<br>");
            }
        }

        SESSION::addFlash('success', "Newsletter envoyée à tous les abonnés !");
        
        $this->redirectTo("newsletter", "index");

        return [

            "view" => VIEW_DIR."newsletters/listNewsletters.php",
            "meta_description" => "Abonnement"

        ];
    }
        
    // Fonction pour envoyer un email
    private function sendEmail($to, $email, $subject, $message, $headers) {

        if(isset($_POST["submit"])){

            $newsletterManager = new NewsletterManager();
        
            // Récupérer tous les abonnés avec leurs emails
            $subscribers = $newsletterManager->getAllSubscribers();
        
            $to = 'sportLink.newsletters@gmail.com';
            $subject = 'Notre dernière newsletter';
            $message = '<h1>Bonjour, voici notre dernière newsletter !</h1><p>Contenu de la newsletter...</p>';
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
            $headers .= "From: sportLink.newsletters@gmail.com" . "\r\n";
            $headers .= "Reply-To: sportLink.newsletters@gmail.com" . "\r\n";
           
        
            // Envoyer l'email à chaque abonné
            foreach ($subscribers as $subscriber) {
        
                // Envoi de l'email
                $sent = mail($to, $email, $subject, $message, $headers);
        
                if ($sent) {
                    SESSION::addFlash('success', "E-mail envoyé à : " . $email . "<br>"); 
                } else {
                    SESSION::addFlash('error', "Erreur lors de l'envoi à : " . $email . "<br>");
                }
            }
        
            SESSION::addFlash('success', "Newsletter envoyée à tous les abonnés !");
        
            $this->redirectTo("newsletter", "index");
            return; 
        
            return [
                "view" => VIEW_DIR . "newsletters/listNewsletters.php",
                "meta_description" => "Abonnement"
            ];
        }
    }
}
