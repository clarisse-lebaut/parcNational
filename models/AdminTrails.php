<?php
require_once __DIR__ . '/../config/connectBDD.php';

class ManageTrails {
    public function count_trails($bdd) {
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM trails");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function get_trails($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM trails");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function name_trails($bdd) {
        $stmt = $bdd->prepare("SELECT name FROM trails LIMIT 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['name'];  // Retourne uniquement le nom
    }
    public function set_trails($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM trails");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function delete_trails($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM trails");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>