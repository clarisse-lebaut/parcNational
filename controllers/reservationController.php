<?php
require_once __DIR__ . '/../models/ReservationModel.php';
require_once __DIR__ . '/../models/CampsiteModel.php';
require_once __DIR__ . '/../controllers/Controller.php';
require_once __DIR__ . '/CampsiteController.php';

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
}
