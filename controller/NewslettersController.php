<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
use Model\Managers\NewslettersManager;
use Model\Managers\UserManager;

class NewslettersController extends AbstractController implements ControllerInterface {

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

            
            $newslettersManager = new NewslettersManager();
            
            // Vérifier si l'email est déjà abonné
            if ($newslettersManager->isSubscribed($email)) {
                
                echo "Cet email est déjà abonné à la newsletter.";

                $this->redirectTo("newsletters", "index");
        
                
            }

            // Vérifier si l'utilisateur est connecté
            $userId = Session::getUser()->getId(); 

            $data = ['email'=>$email, 'user_id'=>$userId];

            // Ajouter l'abonné à la newsletter
            $newslettersManager->add($data);

            echo "Vous êtes maintenant abonné à la newsletter !";

            $this->redirectTo("newsletters", "index");

            return [

                "view" => VIEW_DIR."newsletters/listNewsletters.php",
                "meta_description" => "Abonnement"
    
            ];
        }
    }

    // Envoyer la newsletter à tous les abonnés (en récupérant l'email via une jointure)
    public function sendNewsletter($subject, $message) {

        $newslettersManager = new NewslettersManager();
        // Récupérer tous les abonnés avec leurs emails
        $subscribers = $newslettersManager->getSubscribers();

        // Envoyer l'email à chaque abonné
        foreach ($subscribers as $subscriber) {

            $newslettersManager->sendEmail($subscriber['email'], $subject, $message);
        }
    }
        
    // Fonction pour envoyer un email
    private function sendEmail($to, $subject, $message) {

        $headers = 'From: no-reply@example.com' . "\r\n" .
                   'Reply-To: no-reply@example.com' . "\r\n" .
                   'Content-Type: text/html; charset=UTF-8' . "\r\n";
                   
        mail($to, $subject, $message, $headers);
    }
}
