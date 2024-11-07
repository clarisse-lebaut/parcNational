<?php
require_once __DIR__ . '/../models/ReservationModel.php';
require_once __DIR__ . '/../models/CampsiteModel.php';
require_once __DIR__ . '/../controllers/Controller.php';
require_once __DIR__ . '/CampsiteController.php';

use Dompdf\Dompdf;

class ReservationController extends Controller {

    private $reservationModel;
    private $campsiteController;

    public function __construct() {
        $this->reservationModel = new ReservationModel();  
        $this->campsiteController = new CampsiteController();  
    }

    //? 1: Créer réservation
    public function createReservation($user_id, $campsite_id, $start_date, $end_date, $price) {
        $availability = $this->campsiteController->checkAvailability($campsite_id);
    
        if ($availability === 'Camping complet') {
            return false; // false = complet
        } else {            // crée la réservation 
            $reservation_id = $this->reservationModel->createReservation($user_id, $campsite_id, $start_date, $end_date, $price);
    
            if ($reservation_id) {
                $current_reservations = $this->reservationModel->getCurrentReservations($campsite_id);
                $max_capacity = $this->campsiteController->getMaxCapacity($campsite_id);
    
                if ($current_reservations >= $max_capacity) {
                    $this->campsiteController->updateAvailability($campsite_id, 0); // Camping complet
                }
    
                return $reservation_id; 
            } else {
                return false; 
            }
        }
    }
            
    //? 2: Récupérer toutes les réservations d'un utilisateur
    public function getReservationsByUser($user_id) {
        
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $reservations = $this->reservationModel->getReservationsByUser($user_id);
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        $message = '';
        $recap = null;

        if ($status === 'success' && isset($_SESSION['reservation_id'])) {
            $reservation_id = $_SESSION['reservation_id'];
            $this->reservationModel->updateReservationStatus($reservation_id, "confirmée");
            unset($_SESSION['reservation_id']);
            $message = "Paiement réussi ! Votre réservation a été confirmée.";
            $reservation = $this->reservationModel->getReservationById($reservation_id);
            $recap = [
                'Camping' => $reservation['campsite_name'],
                'Date de début' => date('Y-m-d', strtotime($reservation['start_date'])), 
                'Date de fin' => date('Y-m-d', strtotime($reservation['end_date'])),     
                'Nombre de personnes' => $reservation['num_persons'],
                'Prix total' => $reservation['price'] . ' €'
            ];
        } elseif ($status === 'cancel') {
            $message = "Le paiement a été annulé. Vous pouvez réessayer.";
        }

        $this->render('reservationHistory', [
            'reservations' => $reservations,
            'message' => $message,
            'recap' => $recap
        ]);
    }

    //? 3 : Annuler une réservation
    public function cancelReservation() {
        if (isset($_GET['reservation_id'])) {
            $reservation_id = intval($_GET['reservation_id']);
            $success = $this->reservationModel->cancelReservation($reservation_id);
    
            if ($success) {
                $message = "La réservation a été annulée avec succès.";
            } else {
                $message = "La réservation ne peut pas être annulée (moins de 7 jours avant la date de début).";
            }
        } else {
            $message = "Identifiant de réservation manquant.";
        }
    
        header("Location: reservationHistory?status=cancel&message=" . urlencode($message));
        exit();
    }
    
    //? 4 : Télécharger la facture en PDF
    public function downloadReceipt() {
        if (isset($_GET['reservation_id'])) {
            $reservationId = intval($_GET['reservation_id']);
            $reservationModel = new ReservationModel();
            $reservation = $reservationModel->getReservationById($reservationId);

            $campsiteModel = new CampsiteModel();
            $campsite = $campsiteModel->getCampsiteById($reservation['campsite_id']);

            if ($reservation && $campsite) {
                // contenu HTML pour le reçu
                $html = "
                    <h1>Reçu de réservation</h1>
                    <p>Camping : " . htmlspecialchars($campsite['name']) . "</p>
                    <p>Réservation du " . htmlspecialchars($reservation['start_date']) . " au " . htmlspecialchars($reservation['end_date']) . "</p>
                    <p>Nombre de personnes : " . htmlspecialchars($reservation['num_persons']) . "</p>
                    <p>Prix total : " . htmlspecialchars($reservation['price']) . " €</p>
                    <p>Date de réservation : " . htmlspecialchars($reservation['reservation_date']) . "</p>
                ";

                // Initialise Dompdf
                $dompdf = new Dompdf();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();

                $dompdf->stream("recu_reservation_" . $reservationId . ".pdf", ["Attachment" => true]);
            } else {
                echo "Erreur : réservation ou camping introuvable.";
            }
        } else {
            echo "Erreur : identifiant de réservation manquant.";
        }
    }
}