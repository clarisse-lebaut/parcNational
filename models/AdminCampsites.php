<?php 
require_once __DIR__ . '/../config/connectBDD.php';

class ManageCampsites {
    public function get_campsites($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM campsite");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_campsites_by_id($bdd, $campsite_id) {
        $stmt = $bdd->prepare("SELECT * FROM campsite WHERE campsite_id = :campsite_id");
        $stmt->bindParam(':campsite_id', $campsite_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Récupérer une seule ligne
    }

    public function count_campsites($bdd){
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM campsite");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function name_campsites($bdd) {
        $stmt = $bdd->prepare("SELECT name FROM campsite LIMIT 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['name'];  // Retourne uniquement le nom
    }

    // Méthode pour supprimer un utilisateur spécifique par son ID
    public function delete($bdd, $campsite_id){
        $sql = "DELETE FROM campsite WHERE campsite_id = :campsite_id";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':campsite_id', $campsite_id, PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        } else {
            return false; 
        }
    }

    public function create_campsites($bdd, $name, $description, $address, $city, $zipcode, $status, $max_capacity, $image) {
        $stmt = $bdd->prepare("INSERT INTO campsite (name, description, address, city, zipcode, status, max_capacity, image) 
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
    public function update_campsites($bdd, $campsite_id, $name, $city, $address, $zipcode, $description = null) {
        // Construire la requête SQL
        $sql = "UPDATE campsite SET name = :name, city = :city, address = :address, zipcode = :zipcode";

        // Ajouter la description à la requête seulement si elle est fournie
        if ($description) {
            $sql .= ", description = :description";
        }

        $sql .= " WHERE campsite_id = :campsite_id";
        
        $stmt = $bdd->prepare($sql);

        // Lier les paramètres
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':zipcode', $zipcode, PDO::PARAM_INT);
        $stmt->bindParam(':campsite_id', $campsite_id, PDO::PARAM_INT);

        // Lier la description seulement si elle est fournie
        if ($description) {
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        }

        // Exécuter la requête
        return $stmt->execute();
    }


}