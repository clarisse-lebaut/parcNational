<?php

require_once __DIR__ . '/../config/connectBDD.php';

class CampsiteModel extends connectBDD {

    public function __construct() {
        parent::__construct();
        $this->db = $this->getDb();  
    }

    // 1. Récupérer un camping par ID
    public function getCampsiteById($campsite_id) {
        $query = $this->db->prepare('SELECT * FROM campsite WHERE campsite_id = :campsite_id');
        $query->bindParam(':campsite_id', $campsite_id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // 2. Récupérer tous les campings
    public function getAllCampsites() {
        $query = $this->db->prepare('SELECT * FROM campsite');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Créer un nouveau camping
    public function createCampsite($name, $description, $address, $city, $zipcode, $image, $status) {
        $query = $this->db->prepare('INSERT INTO campsite (name, description, address, city, zipcode, image, status) VALUES (:name, :description, :address, :city, :zipcode, :image, :status)');
        $query->bindParam(':name', $name);
        $query->bindParam(':description', $description);
        $query->bindParam(':address', $address);
        $query->bindParam(':city', $city);
        $query->bindParam(':zipcode', $zipcode);
        $query->bindParam(':image', $image);
        $query->bindParam(':status', $status);
        return $query->execute();
    }

    // 4. Mettre à jour un camping
    public function updateCampsite($campsite_id, $name, $description, $address, $city, $zipcode, $image, $status) {
        $query = $this->db->prepare('UPDATE campsite SET name = :name, description = :description, address = :address, city = :city, zipcode = :zipcode, image = :image, status = :status WHERE campsite_id = :campsite_id');
        $query->bindParam(':name', $name);
        $query->bindParam(':description', $description);
        $query->bindParam(':address', $address);
        $query->bindParam(':city', $city);
        $query->bindParam(':zipcode', $zipcode);
        $query->bindParam(':image', $image);
        $query->bindParam(':status', $status);
        $query->bindParam(':campsite_id', $campsite_id);
        return $query->execute();
    }

    // 5. Supprimer un camping
    public function deleteCampsite($campsite_id) {
        $query = $this->db->prepare('DELETE FROM campsite WHERE campsite_id = :campsite_id');
        $query->bindParam(':campsite_id', $campsite_id);
        return $query->execute();
    }
}
