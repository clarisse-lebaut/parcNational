<?php
require_once __DIR__ . '/../models/Model.php';

class RessourceModel extends Model {

    public function __construct() {
        parent::__construct('natural_ressources');  // Spécifie la table 'natural_ressources'
    }

    // 1. Récupérer une ressource par ID
    public function getRessourceById($ressource_id) {
        $query = $this->pdo->prepare('SELECT * FROM natural_ressources WHERE ressource_id = :ressource_id');
        $query->bindParam(':ressource_id', $ressource_id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // 2. Récupérer toutes les ressources naturelles
    public function getAllRessources() {
        $query = $this->pdo->prepare('SELECT * FROM natural_ressources');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Créer une nouvelle ressource naturelle
    public function createRessource($name, $type, $location, $floraison, $description, $level, $precautions, $image) {
        $query = $this->pdo->prepare('INSERT INTO natural_ressources (name, type, location, floraison, description, level, precautions, image) 
                                     VALUES (:name, :type, :location, :floraison, :description, :level, :precautions, :image)');
        $query->bindParam(':name', $name);
        $query->bindParam(':type', $type);
        $query->bindParam(':location', $location);
        $query->bindParam(':floraison', $floraison);
        $query->bindParam(':description', $description);
        $query->bindParam(':level', $level);
        $query->bindParam(':precautions', $precautions);
        $query->bindParam(':image', $image);
        return $query->execute();
    }

    // 4. Mettre à jour une ressource naturelle
    public function updateRessource($ressource_id, $name, $type, $location, $floraison, $description, $level, $precautions, $image) {
        $query = $this->pdo->prepare('UPDATE natural_ressources SET name = :name, type = :type, location = :location, floraison = :floraison, 
                                     description = :description, level = :level, precautions = :precautions, image = :image WHERE ressource_id = :ressource_id');
        $query->bindParam(':name', $name);
        $query->bindParam(':type', $type);
        $query->bindParam(':location', $location);
        $query->bindParam(':floraison', $floraison);
        $query->bindParam(':description', $description);
        $query->bindParam(':level', $level);
        $query->bindParam(':precautions', $precautions);
        $query->bindParam(':image', $image);
        $query->bindParam(':ressource_id', $ressource_id);
        return $query->execute();
    }

    // 5. Supprimer une ressource naturelle
    public function deleteRessource($ressource_id) {
        $query = $this->pdo->prepare('DELETE FROM natural_ressources WHERE ressource_id = :ressource_id');
        $query->bindParam(':ressource_id', $ressource_id);
        return $query->execute();
    }

function getFilteredRessources() {
    // Exemple d'extraction des paramètres de requête
    $types = isset($_GET['type']) ? explode(',', $_GET['type']) : [];

    // Préparer la requête SQL
    $query = "SELECT * FROM natural_ressources WHERE 1=1"; // Toujours vrai pour simplifier
    $params = []; // Tableau pour stocker les paramètres liés

    // Si des types ont été fournis, ajouter les conditions de filtre
    if (!empty($types)) {
        $typeConditions = [];
        foreach ($types as $type) {
            $type = trim($type);
            // Utilisation de placeholders pour éviter l'injection SQL
            $typeConditions[] = "type LIKE :type" . count($params); // Créer un placeholder unique
            $params[] = "%" . $type . "%"; // Ajouter la valeur au tableau des paramètres
        }
        $query .= " AND (" . implode(' OR ', $typeConditions) . ")";
    }

    // Exécuter la requête et récupérer les résultats
    $stmt = $this->pdo->prepare($query);

    // Lier les paramètres dynamiques
    foreach ($params as $key => $value) {
        $stmt->bindValue(':type' . $key, $value); // Lier chaque paramètre
    }

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retourner les résultats en JSON
    header('Content-Type: application/json');
    echo json_encode($results);
    exit; // Arrêter l'exécution pour éviter l'affichage de 'null' ou autre sortie
}


}
