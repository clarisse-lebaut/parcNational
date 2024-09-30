<?php 
require_once __DIR__ . '/../config/connectBDD.php';

class AdminData {
    public function get_user($bdd){
        $sql = "SELECT * FROM users";
        $stmt = $bdd->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count_users($bdd) {
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM users");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function count_trails($bdd) {
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM trails");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function count_campsites($bdd){
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM campsite");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function count_ressources($bdd){
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM natural_ressources");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function count_rapports($bdd){
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM reports");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function last_trails($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM trails LIMIT 3");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function last_campsites($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM campsite LIMIT 3");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function last_ressources($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM natural_ressources LIMIT 3");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function last_rapports($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM reports LIMIT 3");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}