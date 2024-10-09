<?php
require_once __DIR__ . '/../config/connectBDD.php';

class ManageTrails {
    public function count_trails($bdd) {
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM trails");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function get_trails($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM trails");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get_trails_by_id($bdd, $trail_id) {
        $stmt = $bdd->prepare("SELECT * FROM trails WHERE trail_id = :trail_id");
        $stmt->bindParam(':trail_id', $trail_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Récupérer une seule ligne
    }
    public function name_trails($bdd) {
        $stmt = $bdd->prepare("SELECT name FROM trails LIMIT 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['name'];  // Retourne uniquement le nom
    }
    // Méthode pour supprimer un utilisateur spécifique par son ID
    public function delete($bdd, $trail_id){
        $sql = "DELETE FROM trails WHERE trail_id = :trail_id";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':trail_id', $trail_id, PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        } else {
            return false; 
        }
    }

    public function create_trails($bdd, $name, $description, $distance, $difficulty, $status, $image, $longitude, $latitude) {
        $sql = "INSERT INTO trails (name, description, distance, difficulty, status, image, longitude, latitude)
                VALUES (:name, :description, :distance, :difficulty, :status, :image, :longitude, :latitude)";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':distance', $distance);
        $stmt->bindParam(':difficulty', $difficulty);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':longitude', $longitude);
        $stmt->bindParam(':latitude', $latitude);
        return $stmt->execute();
    }

    public function update_trails($bdd, $trail_id, $name, $description, $distance, $difficulty, $status, $image, $longitude, $latitude) {
        // Préparation de la requête SQL avec les champs longitude et latitude
        $sql = "UPDATE trails SET 
                    name = :name, 
                    description = :description, 
                    distance = :distance, 
                    difficulty = :difficulty, 
                    status = :status, 
                    image = :image, 
                    longitude = :longitude, 
                    latitude = :latitude
                WHERE trail_id = :trail_id";
        
        // Préparation de la requête
        $stmt = $bdd->prepare($sql);
        
        // Association des paramètres à la requête
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':distance', $distance);
        $stmt->bindParam(':difficulty', $difficulty);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':longitude', $longitude); // Correct binding for longitude
        $stmt->bindParam(':latitude', $latitude);   // Correct binding for latitude
        $stmt->bindParam(':trail_id', $trail_id);   // Binding the trail ID

        // Exécution de la requête
        return $stmt->execute();
    }

    public function insertGeographicData($trail_id, $type, $part_number, $coordinate_number, $longitude, $latitude) {
        $sql = "INSERT INTO votre_table_geographique (trail_id, type, part_number, coordinate_number, longitude, latitude)
                VALUES (:trail_id, :type, :part_number, :coordinate_number, :longitude, :latitude)";
        
        $stmt = $this->bdd->prepare($sql);
        
        // Lier les paramètres
        $stmt->bindParam(':trail_id', $trail_id);
        $stmt->bindParam(':type', $type); // Remplacez par le type que vous voulez utiliser
        $stmt->bindParam(':part_number', $part_number);
        $stmt->bindParam(':coordinate_number', $coordinate_number);
        $stmt->bindParam(':longitude', $longitude);
        $stmt->bindParam(':latitude', $latitude);
        
        if ($stmt->execute()) {
            return true; // Insertion réussie
        } else {
            return false; // Échec de l'insertion
        }
    }


}
?>