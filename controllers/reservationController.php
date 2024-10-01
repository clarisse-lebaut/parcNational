<?php
require_once __DIR__ . '/../models/ReservationModel.php';
require_once __DIR__ . '/Controller.php';

class ReservationController extends Controller {

    private $reservationModel;

    public function __construct() {
        $this->reservationModel = new ReservationModel(); 
    }

    // Créer réservation
    public function createReservation($user_id, $campsite_id, $start_date, $end_date, $price) {
        if ($this->reservationModel->createReservation($user_id, $campsite_id, $start_date, $end_date, $price)) {
            $message = 'La réservation a été créée avec succès.';
        } else {
            $message = 'Erreur lors de la création de la réservation.';
        }
        
        // Rediriger vers l'historique avec un message de confirmation ou d'erreur
        $this->render('reservationHistory', [
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