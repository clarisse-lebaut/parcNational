<?php 
require_once 'Model.php';

class ManageReports extends Model {
    public function __construct($table){
        parent::__construct($table);
    }
    public function get_reports() {
        $stmt = $this->pdo->prepare("SELECT reports.*, natural_ressources.name AS ressource_name FROM reports LEFT JOIN natural_ressources ON reports.resource_id = natural_ressources.ressource_id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_reports_by_id($report_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM reports WHERE report_id = :report_id");
        $stmt->bindParam(':report_id', $report_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);    
    }

    public function count_reports(){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM reports");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function name_reports() {
        $stmt = $this->pdo->prepare("SELECT name FROM reports LIMIT 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification que $result n'est pas false avant de tenter d'accéder à 'name'
        return $result ? $result['name'] : null; // Retourner null si aucun résultat
    }

    public function name_ressource() {
        $stmt = $this->pdo->prepare("SELECT ressource_id, name FROM natural_ressources");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($report_id) {
        $stmt = $this->pdo->prepare("DELETE FROM reports WHERE report_id = :report_id");
        $stmt->bindParam(':report_id', $report_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function create_report($name, $description, $resource_id) {
        $stmt = $this->pdo->prepare("INSERT INTO reports (name, description, resource_id) VALUES (:name, :description, :resource_id)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':resource_id', $resource_id);
        return $stmt->execute();
    }

    public function update_report($report_id, $name, $description, $resource_id) {
        // Préparation de la requête de mise à jour
        $stmt = $this->pdo->prepare(" UPDATE reports 
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