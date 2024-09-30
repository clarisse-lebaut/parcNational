<?php 
require_once __DIR__ . '/../config/connectBDD.php';

class ManageCampsites {
    public function get_campsites($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM campsite");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    
    public function set_campsites($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM campsite");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete_campsites($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM campsite");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}