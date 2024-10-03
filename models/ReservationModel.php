<?php
require_once __DIR__ . '/../config/connectBDD.php';

class ReservationModel extends connectBDD {

    public function __construct() {
        parent::__construct();
        $this->db = $this->getDb();
    }

    public function createReservation($user_id, $campsite_id, $start_date, $end_date, $price, $status = "en attente") {
        $query = $this->db->prepare('INSERT INTO reservations (user_id, campsite_id, start_date, end_date, price, reservation_date, status) VALUES (:user_id, :campsite_id, :start_date, :end_date, :price, NOW(), :status)');
        $query->bindParam(':user_id', $user_id);
        $query->bindParam(':campsite_id', $campsite_id);
        $query->bindParam(':start_date', $start_date);
        $query->bindParam(':end_date', $end_date);
        $query->bindParam(':price', $price);
        $query->bindParam(':status', $status);
        $query->execute();

        // Retourner l'ID de la réservation nouvellement créée
        return $this->db->lastInsertId();
    }

    public function updateReservationStatus($reservation_id, $status) {
        $query = $this->db->prepare('UPDATE reservations SET status = :status WHERE reservation_id = :reservation_id');
        $query->bindParam(':status', $status);
        $query->bindParam(':reservation_id', $reservation_id);
        return $query->execute();
    }
    public function getReservationsByUser($user_id) {
        $query = $this->db->prepare('SELECT r.*, c.name AS campsite_name FROM reservations r JOIN campsite c ON r.campsite_id = c.campsite_id WHERE r.user_id = :user_id ORDER BY r.reservation_date DESC');
        $query->bindParam(':user_id', $user_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReservationById($reservation_id) {
        $query = $this->db->prepare('SELECT * FROM reservations WHERE reservation_id = :reservation_id');
        $query->bindParam(':reservation_id', $reservation_id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function cancelReservation($reservation_id) {
        $query = $this->db->prepare('SELECT start_date FROM reservations WHERE reservation_id = :reservation_id');
        $query->bindParam(':reservation_id', $reservation_id);
        $query->execute();
        $reservation = $query->fetch(PDO::FETCH_ASSOC);
    
        if ($reservation) {
            $start_date = new DateTime($reservation['start_date']);
            $current_date = new DateTime();
            $interval = $current_date->diff($start_date)->days;
    
            // annulation possible que 7j avant
            if ($interval >= 7) {
                $query = $this->db->prepare('UPDATE reservations SET status = "annulée" WHERE reservation_id = :reservation_id');
                $query->bindParam(':reservation_id', $reservation_id);
                return $query->execute();
            } else {
                return false; 
            }
        }
    
        return false; // Réservation introuvable
    }
    
}
