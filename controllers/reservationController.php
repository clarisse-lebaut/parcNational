<?php
require_once __DIR__ . '/../models/ReservationModel.php';
require_once __DIR__ . '/../models/CampsiteModel.php';
require_once __DIR__ . '/../controllers/Controller.php';

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
        $this->render('reservationHistory', ['reservations' => $reservations]);
    }
}
