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
        $reservations = $this->reservationModel->getReservationsByUser($user_id);
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        $message = '';
    
        if ($status === 'success' && isset($_SESSION['reservation_id'])) {
            $reservation_id = $_SESSION['reservation_id'];
            $this->reservationModel->updateReservationStatus($reservation_id, "confirmée");
            unset($_SESSION['reservation_id']);
            $message = "Paiement réussi ! Votre réservation a été confirmée.";
        } elseif ($status === 'cancel') {
            $message = "Le paiement a été annulé. Vous pouvez réessayer.";
        }
    
        $this->render('reservationHistory', [
            'reservations' => $reservations,
            'message' => $message
        ]);
    }
    }
