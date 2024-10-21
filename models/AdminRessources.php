<?php 
require_once 'Model.php';

class ManageRessources extends Model {
    public function __construct($table){
        parent::__construct($table);
    }
    public function get_ressources() {
        $stmt = $this->pdo->prepare("SELECT * FROM natural_ressources");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_ressources_by_id($ressource_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM natural_ressources WHERE ressource_id = :ressource_id");
        $stmt->bindParam(':ressource_id', $ressource_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Récupérer une seule ligne
    }

    public function count_ressources() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM natural_ressources");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function name_ressources() {
        $stmt = $this->pdo->prepare("SELECT name FROM natural_ressources LIMIT 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['name'] ?? null; // Retourne le nom ou null si aucune ressource
    }

    public function delete($ressource_id) {
        $stmt = $this->pdo->prepare("DELETE FROM natural_ressources WHERE ressource_id = :ressource_id");
        $stmt->bindParam(':ressource_id', $ressource_id, PDO::PARAM_INT);
        return $stmt->execute(); // Exécuter la requête et retourner le résultat
    }

    public function create_ressource($name, $type, $location, $floraison, $description, $level, $precautions, $image) {
        $stmt = $this->pdo->prepare("INSERT INTO natural_ressources (name, type, location, floraison, description, level, precautions, image) 
                            VALUES (:name, :type, :location, :floraison, :description, :level, :precautions, :image)");
        return $stmt->execute([
            ':name' => $name,
            ':type' => $type,
            ':location' => $location,
            ':floraison' => $floraison,
            ':description' => $description,
            ':level' => $level,
            ':precautions' => $precautions,
            ':image' => $image
        ]);
    }

    // Mettre à jour une ressource
    public function update_ressources($ressource_id, $name, $type, $location, $floraison, $level, $precautions, $description = null) {
        // Construire la requête SQL
        $sql = "UPDATE natural_ressources SET name = :name, type = :type, location = :location, floraison = :floraison, level = :level, precautions = :precautions";

        // Ajouter la description à la requête seulement si elle est fournie
        if ($description !== null) {
            $sql .= ", description = :description";
        }

        $sql .= " WHERE ressource_id = :ressource_id";

        $stmt = $this->pdo->prepare($sql);

        // Lier les paramètres
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':location', $location, PDO::PARAM_STR);
        $stmt->bindParam(':floraison', $floraison, PDO::PARAM_STR);
        $stmt->bindParam(':level', $level, PDO::PARAM_STR);
        $stmt->bindParam(':precautions', $precautions, PDO::PARAM_STR);
        $stmt->bindParam(':ressource_id', $ressource_id, PDO::PARAM_INT);

        // Lier la description seulement si elle est fournie
        if ($description !== null) {
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        }

        // Exécuter la requête
        return $stmt->execute();
    }
}
