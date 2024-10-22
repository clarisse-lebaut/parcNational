<?php
require_once 'Model.php';

class ManageTrails extends Model {

    public function __construct($table){
        parent::__construct($table);
    }
    public function count_trails() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM trails");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function get_trails() {
        $stmt = $this->pdo->prepare("SELECT * FROM trails");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get_trails_by_id($trail_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM trails WHERE trail_id = :trail_id");
        $stmt->bindParam(':trail_id', $trail_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Récupérer une seule ligne
    }
    public function name_trails() {
        $stmt = $this->pdo->prepare("SELECT name FROM trails LIMIT 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['name'];  // Retourne uniquement le nom
    }
    // Méthode pour supprimer un utilisateur spécifique par son ID
    public function delete($trail_id){
        $sql = "DELETE FROM trails WHERE trail_id = :trail_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':trail_id', $trail_id, PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        } else {
            return false; 
        }
    }

public function create_trails($name, $difficulty, $length_km, $time, $description, $status, $infos, $acces, $image = null) {
    $sql = "INSERT INTO trails (name, difficulty, length_km, time, description, status, infos, acces" .
            ($image ? ", image" : "") . ") " .  // Ajouter "image" seulement si $image est défini
            "VALUES (:name, :difficulty, :length_km, :time, :description, :status, :infos, :acces" .
            ($image ? ", :image" : "") . ")";   // Ajouter la valeur de l'image seulement si $image est défini

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':difficulty', $difficulty);
    $stmt->bindParam(':length_km', $length_km);
    $stmt->bindParam(':time', $time);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':infos', $infos);
    $stmt->bindParam(':acces', $acces);

    // Lier l'image seulement si elle est fournie
    if ($image) {
        $stmt->bindParam(':image', $image);
    }

    return $stmt->execute();
}


public function update_trails($trail_id, $name, $difficulty, $length_km, $time, $description, $status, $infos, $acces, $image = null) {
    $sql = "UPDATE trails SET 
                name = :name, 
                difficulty = :difficulty, 
                length_km = :length_km, 
                time = :time, 
                description = :description,
                status = :status,
                infos = :infos,
                acces = :acces";
    
    // Ajouter la mise à jour de l'image seulement si une nouvelle image est fournie
    if ($image) {
        $sql .= ", image = :image";
    }
    
    $sql .= " WHERE trail_id = :trail_id";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':difficulty', $difficulty);
    $stmt->bindParam(':length_km', $length_km);
    $stmt->bindParam(':time', $time);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':infos', $infos);
    $stmt->bindParam(':acces', $acces);
    $stmt->bindParam(':trail_id', $trail_id);

    // Lier l'image seulement si elle est fournie
    if ($image) {
        $stmt->bindParam(':image', $image);
    }

    return $stmt->execute();
}


}
?>