<?php
require_once __DIR__ . '/../models/ReservationModel.php';
require_once __DIR__ . '/Controller.php';

class ReservationController extends Controller {

    private $reservationModel;

    public function __construct() {
        $this->reservationModel = new ReservationModel(); 
    }

    // 1. Créer réservation
    public function createReservation($user_id, $campsite_id, $start_date, $end_date, $price) {
        if ($this->reservationModel->createReservation($user_id, $campsite_id, $start_date, $end_date, $price)) {
            $this->render('reservationSuccess', ['message' => 'La réservation a été créée avec succès.']);
        } else {
            $this->render('reservationError', ['message' => 'Erreur lors de la création de la réservation.']);
        }
    }
    
    // 2. Récupérer réservations par user
    public function getReservationsByUser($user_id) {
        $reservations = $this->reservationModel->getReservationsByUser($user_id);
        $this->render('reservationList', ['reservations' => $reservations]);
    }

    // 3. Récupérer une réservation par ID
    public function getReservationById($reservation_id) {
        $reservation = $this->reservationModel->getReservationById($reservation_id);
        $this->render('reservationDetail', ['reservation' => $reservation]);
    }

    // 4. Modifier statut
    public function updateReservationStatus($reservation_id, $status) {
        if ($this->reservationModel->updateReservationStatus($reservation_id, $status)) {
            $this->render('reservationStatusUpdate', ['message' => 'Le statut de la réservation a été mis à jour.']);
        } else {
            $this->render('reservationError', ['message' => 'Erreur lors de la mise à jour du statut.']);
        }
    }
}