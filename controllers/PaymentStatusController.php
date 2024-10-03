<?php

require_once 'Controller.php';
require_once __DIR__ . '/../model/Membership.php';
require_once __DIR__ . '/../model/User.php';
require_once 'UserMembershipController.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PaymentStatusController extends Controller{
        
    public function __construct() {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

    public function paymentSuccess() {
        if (isset($_SESSION['user_email'], $_SESSION['random_id'], $_SESSION['expiry_date'], $_SESSION['name'])) {
            $userEmail = $_SESSION['user_email'];
            $randomID = $_SESSION['random_id'];
            $expiryDate = $_SESSION['expiry_date'];
            $name = $_SESSION['name'];
            $this->sendConfirmationEmail($userEmail, $randomID, $expiryDate, $name);
            unset($_SESSION['user_email'], $_SESSION['random_id'], $_SESSION['expiry_date'], $_SESSION['name']);
            $message = "Votre paiement a été effectué avec succès.";
            $this->render('paymentSuccess', ['message' => $message]);
        } else {
            $this->render('paymentSuccess', ['message' => 'Erreur: Impossible d\'envoyer la confirmation.']);
        }
    }

    public function paymentFailed() {
    $message = "Votre paiement a échoué. Veuillez réessayer.";
    $this->render('paymentFailed', ['message' => $message]);
    }

    public function sendConfirmationEmail($userEmail, $randomId, $expiryDate, $name) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->setFrom('no-reply@parcNational.com', 'No Reply');
            $mail->addAddress($userEmail); 
            $mail->isHTML(true);
            $mail->Subject = "Confirmation d'adhésion";
            $mail->Body = "

                <html>
                <head>
                    <title>Confirmation d'adhésion</title>
                </head>
                <body>
                    <h2>Merci pour votre adhésion !</h2>
                    <p>Madamme/Monsieur: <strong>$name</strong></p>
                    <p>Votre numéro d'identification est: <strong>$randomId</strong></p>
                    <p>Date d'expiration de l'abonnement: $expiryDate</p>
                    <p>Présentez ce numéro pour obtenir des réductions.</p>
                </body>
                </html>
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log("L'erreur lors de l'envoi de l'email: {$mail->ErrorInfo}");
        }
    }
}