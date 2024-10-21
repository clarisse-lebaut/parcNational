<?php
class CoveModel {
    private $db;

    public function __construct() {
        $this->db = (new ConnectBD())->getDb();
    }

    // Récupérer toutes les calanques
    public function getAllCoves() {
        $query = "SELECT * FROM coves";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter une nouvelle calanque
    public function createCove($name, $description, $location, $image) {
        $query = "INSERT INTO coves (name, description, location, image) VALUES (:name, :description, :location, :image)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':image', $image);
        $stmt->execute();
    }

    // Modifier calanque
    public function updateCove($id, $name, $description, $location, $image) {
        $query = "UPDATE coves SET name = :name, description = :description, location = :location, image = :image WHERE cove_id = :id";
        $stmt = $this->db->prepare($query);
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
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
