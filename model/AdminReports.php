<?php 
require_once __DIR__ . '/../config/connectBDD.php';

class ManageReports {
    public function get_reports($bdd) {
        $stmt = $bdd->prepare("SELECT reports.*, natural_ressources.name AS ressource_name FROM reports LEFT JOIN natural_ressources ON reports.resource_id = natural_ressources.ressource_id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_reports_by_id($bdd, $report_id) {
        $stmt = $bdd->prepare("SELECT * FROM reports WHERE report_id = :report_id");
        $stmt->bindParam(':report_id', $report_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);    
    }

    public function count_reports($bdd){
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM reports");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function name_reports($bdd) {
        $stmt = $bdd->prepare("SELECT name FROM reports LIMIT 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification que $result n'est pas false avant de tenter d'accéder à 'name'
        return $result ? $result['name'] : null; // Retourner null si aucun résultat
    }

    public function name_ressource($bdd) {
        $stmt = $bdd->prepare("SELECT ressource_id, name FROM natural_ressources");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($bdd, $report_id) {
        $stmt = $bdd->prepare("DELETE FROM reports WHERE report_id = :report_id");
        $stmt->bindParam(':report_id', $report_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function create_report($bdd, $name, $description, $resource_id) {
        $stmt = $bdd->prepare("INSERT INTO reports (name, description, resource_id) VALUES (:name, :description, :resource_id)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':resource_id', $resource_id);
        return $stmt->execute();
    }

    public function update_report($bdd, $report_id, $name, $description, $resource_id) {
        // Préparation de la requête de mise à jour
        $stmt = $bdd->prepare(" UPDATE reports 
            SET name = :name, description = :description, resource_id = :resource_id 
            WHERE report_id = :report_id
        ");

        // Liaison des paramètres avec les valeurs
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':resource_id', $resource_id, PDO::PARAM_INT);
        $stmt->bindParam(':report_id', $report_id, PDO::PARAM_INT);

        // Exécution de la requête
        return $stmt->execute();
    }

}