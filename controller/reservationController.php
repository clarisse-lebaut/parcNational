<?php
require_once __DIR__ . '/../model/ReservationModel.php';

class ReservationController {

    private $reservationModel;

    public function __construct() {
        $this->reservationModel = new ReservationModel(); 
    }

    // 1. Créer réservation
    public function createReservation($user_id, $campsite_id, $start_date, $end_date, $price) {
        if ($this->reservationModel->createReservation($user_id, $campsite_id, $start_date, $end_date, $price)) {
            return "La réservation a été créée avec succès.";
        } else {
            return "Erreur lors de la création de la réservation.";
        }
    }

    // 2. Récupérer réservations par uer
    public function getReservationsByUser($user_id) {
        return $this->reservationModel->getReservationsByUser($user_id);
    }

    // 3. Récupérer une réservation par ID
    public function getReservationById($reservation_id) {
        return $this->reservationModel->getReservationById($reservation_id);
    }

    // 4. Modifier statut
    public function updateReservationStatus($reservation_id, $status) {
        if ($this->reservationModel->updateReservationStatus($reservation_id, $status)) {
            return "Le statut de la réservation a été mis à jour.";
        } else {
            return "Erreur lors de la mise à jour du statut.";
        }
    }
}