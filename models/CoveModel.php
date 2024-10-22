<?php
require_once __DIR__ . '/Model.php';

class CoveModel extends Model {
    
    public function __construct() {
        parent::__construct('coves');  
    }

    // Récupérer toutes les calanques
    public function getAllCoves() {
        $query = "SELECT * FROM coves";
        $stmt = $this->pdo->prepare($query); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter une nouvelle calanque
    public function createCove($name, $description, $location, $image) {
        $query = "INSERT INTO coves (name, description, location, image) VALUES (:name, :description, :location, :image)";
        $stmt = $this->pdo->prepare($query); 
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':image', $image);
        $stmt->execute();
    }

    // Modifier une calanque
    public function updateCove($id, $name, $description, $location, $image) {
        $query = "UPDATE coves SET name = :name, description = :description, location = :location, image = :image WHERE cove_id = :id";
        $stmt = $this->pdo->prepare($query); 
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    // Supprimer une calanque
    public function deleteCove($id) {
        $query = "DELETE FROM coves WHERE cove_id = :id";
        $stmt = $this->pdo->prepare($query); 
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
