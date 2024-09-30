<?php 
require_once __DIR__ . '/../config/connectBDD.php';

class ManageReports {
    public function get_reports($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM reports");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    
    public function set_reports($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM reports");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function delete_reports($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM reports");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}