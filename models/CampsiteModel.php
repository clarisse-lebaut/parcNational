<?php

require_once __DIR__ . '/../models/Model.php'; // Utilisation de la classe Model

class CampsiteModel extends Model {

    public function __construct() {
        parent::__construct('campsite'); 
    }

    // 1. Récupérer un camping par ID
    public function getCampsiteById($campsite_id) {
        $query = $this->pdo->prepare('SELECT * FROM campsite WHERE campsite_id = :campsite_id');
        $query->bindParam(':campsite_id', $campsite_id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // 2. Récupérer tous les campings
    public function getAllCampsites() {
        $query = $this->pdo->prepare('SELECT * FROM campsite');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // 3. Créer un nouveau camping
    public function createCampsite($name, $description, $address, $city, $zipcode, $image, $status, $max_capacity) {
        $query = $this->pdo->prepare('INSERT INTO campsite (name, description, address, city, zipcode, image, status, max_capacity) 
                                     VALUES (:name, :description, :address, :city, :zipcode, :image, :status, :max_capacity)');
        $query->bindParam(':name', $name);
        $query->bindParam(':description', $description);
        $query->bindParam(':address', $address);
        $query->bindParam(':city', $city);
        $query->bindParam(':zipcode', $zipcode);
        $query->bindParam(':image', $image);
        $query->bindParam(':status', $status);
        $query->bindParam(':max_capacity', $max_capacity);
        return $query->execute();
    }

    // 4. Mettre à jour un camping
    public function updateCampsite($campsite_id, $name, $description, $address, $city, $zipcode, $image, $status, $max_capacity) {
        $query = $this->pdo->prepare('UPDATE campsite SET name = :name, description = :description, address = :address, city = :city, 
                                     zipcode = :zipcode, image = :image, status = :status, max_capacity = :max_capacity WHERE campsite_id = :campsite_id');
        $query->bindParam(':name', $name);
        $query->bindParam(':description', $description);
        $query->bindParam(':address', $address);
        $query->bindParam(':city', $city);
        $query->bindParam(':zipcode', $zipcode);
        $query->bindParam(':image', $image);
        $query->bindParam(':status', $status);
        $query->bindParam(':max_capacity', $max_capacity);
        $query->bindParam(':campsite_id', $campsite_id);
        return $query->execute();
    }

    // 5. Supprimer un camping
    public function deleteCampsite($campsite_id) {
        $query = $this->pdo->prepare('DELETE FROM campsite WHERE campsite_id = :campsite_id');
        $query->bindParam(':campsite_id', $campsite_id);
        return $query->execute();
    }

    // 6. Modifier statut d'un camping en fonction des vacances
    public function updateStatus($campsite_id, $status) {
        $query = $this->pdo->prepare('UPDATE campsite SET status = :status WHERE campsite_id = :campsite_id');
        $query->bindParam(':status', $status);
        $query->bindParam(':campsite_id', $campsite_id);
        return $query->execute();
    }
    
    // 7. Modifier la disponibilité (capacité)
    public function updateAvailability($campsite_id, $availability) {
        $query = $this->pdo->prepare('UPDATE campsite SET availability = :availability WHERE campsite_id = :campsite_id');
        $query->bindParam(':availability', $availability);
        $query->bindParam(':campsite_id', $campsite_id);
        return $query->execute();
    }

    // 8. Vérifier la disponibilité d'un camping
    public function checkAvailability($campsite_id) {
        $query = $this->pdo->prepare('SELECT availability FROM campsite WHERE campsite_id = :campsite_id');
        $query->bindParam(':campsite_id', $campsite_id);
        $query->execute();
        return $query->fetchColumn(); // (1 = disponible, 0 = complet)
    }

    // 9. Vérifier la capacité maximale
    public function getMaxCapacity($campsite_id) {
        $query = $this->pdo->prepare('SELECT max_capacity FROM campsite WHERE campsite_id = :campsite_id');
        $query->bindParam(':campsite_id', $campsite_id);
        $query->execute();
        return $query->fetchColumn(); // Retourne capacité max du camping
    }
}
