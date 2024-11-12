<?php 
require_once 'Model.php';

class ManageCampsites extends Model {
    public function __construct($table){
        parent::__construct($table);
    }
    public function get_campsites() {
        $stmt = $this->pdo->prepare("SELECT * FROM campsite");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_campsites_by_id($campsite_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM campsite WHERE campsite_id = :campsite_id");
        $stmt->bindParam(':campsite_id', $campsite_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Récupérer une seule ligne
    }

    public function count_campsites(){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM campsite");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function name_campsites() {
        $stmt = $this->pdo->prepare("SELECT name FROM campsite LIMIT 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['name'];  // Retourne uniquement le nom
    }

    // Méthode pour supprimer un utilisateur spécifique par son ID
    public function delete($campsite_id){
        $sql = "DELETE FROM campsite WHERE campsite_id = :campsite_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':campsite_id', $campsite_id, PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        } else {
            return false; 
        }
    }

    public function create_campsites($name, $description, $address, $city, $zipcode, $status, $max_capacity, $image) {
        $stmt = $this->pdo->prepare("INSERT INTO campsite (name, description, address, city, zipcode, status, max_capacity, image) 
                            VALUES (:name, :description, :address, :city, :zipcode, :status, :max_capacity, :image)");
        return $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':address' => $address,
            ':city' => $city,
            ':zipcode' => $zipcode,
            ':status' => $status,
            ':max_capacity' => $max_capacity,
            ':image' => $image // Vous pouvez gérer l'upload d'image côté serveur
        ]);
    }

    // Mettre à jour un camping
    public function update_campsites($campsite_id, $name, $description, $address, $city, $zipcode,$status, $max_capacity) {
        // Construire la requête SQL
        $sql = "UPDATE campsite SET name = :name, city = :city, address = :address, zipcode = :zipcode, status = :status, max_capacity = :max_capacity";

        // Ajouter la description à la requête seulement si elle est fournie
        if ($description) {
            $sql .= ", description = :description";
        }

        $sql .= " WHERE campsite_id = :campsite_id";
        
        $stmt = $this->pdo->prepare($sql);

        // Lier les paramètres
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':zipcode', $zipcode, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':max_capacity', $max_capacity, PDO::PARAM_INT);
        $stmt->bindParam(':campsite_id', $campsite_id, PDO::PARAM_INT);

        // Lier la description seulement si elle est fournie
        if ($description) {
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        }

        // Exécuter la requête
        return $stmt->execute();
    }


}