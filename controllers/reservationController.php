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

    // Créer une réservation après vérification de la disponibilité
    public function createReservation($user_id, $campsite_id, $start_date, $end_date, $price) {
        $availability = $this->campsiteController->checkAvailability($campsite_id);

        if ($availability === 'Camping complet') {
            $message = 'Désolé, ce camping est complet.';
        } else {
            if ($this->reservationModel->createReservation($user_id, $campsite_id, $start_date, $end_date, $price)) {
                $currentReservations = $this->reservationModel->getCurrentReservations($campsite_id);
                $maxCapacity = $this->campsiteController->getMaxCapacity($campsite_id);

                if ($currentReservations >= $maxCapacity) {
                    $this->campsiteController->updateAvailability($campsite_id, 0);  // Camping complet
                }

                $message = 'La réservation a été créée avec succès.';
            } else {
                $message = 'Erreur lors de la création de la réservation.';
            }
        }
        $this->render('reservationHistory', [  // Redirige vers l'historique
            'reservations' => $this->reservationModel->getReservationsByUser($user_id),
            'message' => $message
        ]);
    }

    // Récupérer toutes les réservations d'un utilisateur
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
