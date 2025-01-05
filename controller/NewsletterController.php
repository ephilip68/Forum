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

    

    // Gérer l'abonnement à la newsletter
    public function subscribe() {
        
        if(isset($_POST["submit"])){

            // Récupérer les données du formulaire
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

            $newsletterManager = new NewsletterManager();
            
            // Vérifier si l'email est déjà abonné
            if ($newsletterManager->isSubscribed($email)) {
                
                echo "Cet email est déjà abonné à la newsletter.";

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
                $newsletterController->sendEmail($to, $subject, $message);

                // Message de confirmation
                $message = "Vous êtes maintenant inscrit à la newsletter et vous avez reçu notre dernière édition !";
            } else {
                $message = "Une erreur est survenue, veuillez réessayer.";
            }
        } else {
            $message = "L'adresse email est requise.";
        }
            

            $this->redirectTo("newsletter", "index");



            return [

                "view" => VIEW_DIR."newsletters/listNewsletters.php",
                "meta_description" => "Abonnement"
    
            ];
        
    }

    // Envoyer la newsletter à tous les abonnés (en récupérant l'email via une jointure)
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
                echo "E-mail envoyé à : " . $email . "<br>";
            } else {
                echo "Erreur lors de l'envoi à : " . $email . "<br>";
            }
        }

        echo "Newsletter envoyée à tous les abonnés !";
        return;
        
        $this->redirectTo("newsletter", "index");
        return; 

        return [

            "view" => VIEW_DIR."newsletters/listNewsletters.php",
            "meta_description" => "Abonnement"

        ];
    }
        
    // Fonction pour envoyer un email
    private function sendEmail($to, $subject, $message) {

        if(isset($_POST["submit"])){

            $newsletterManager = new NewsletterManager();
        
            // Récupérer tous les abonnés avec leurs emails
            $subscribers = $newsletterManager->getAllSubscribers();
        
            $to = 'erwin.philip68@gmail.com';
            $subject = 'Notre dernière newsletter';
            $message = '<h1>Bonjour, voici notre dernière newsletter !</h1><p>Contenu de la newsletter...</p>';
           
        
            // Envoyer l'email à chaque abonné
            foreach ($subscribers as $subscriber) {
        
        
                // Envoi de l'email
                $sent = mail($to, $subject, $message);
        
                if ($sent) {
                    echo "E-mail envoyé à : " . $to . "<br>";
                } else {
                    echo "Erreur lors de l'envoi à : " . $to . "<br>";
                }
            }
        
            echo "Newsletter envoyée à tous les abonnés !";
        
            // Redirection après envoi
            $this->redirectTo("newsletter", "index");
            return; 
        
            return [
                "view" => VIEW_DIR . "newsletters/listNewsletters.php",
                "meta_description" => "Abonnement"
            ];
        }
    }
}
