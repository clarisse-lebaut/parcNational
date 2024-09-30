<?php 
require_once __DIR__ . '/../config/connectBDD.php';

class ManageRessources {
        public function get_ressources($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM natural_ressources");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count_ressources($bdd){
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM natural_ressources");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function name_ressources($bdd) {
        $stmt = $bdd->prepare("SELECT name FROM natural_ressources LIMIT 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['name'];  // Retourne uniquement le nom
    }
    public function set_ressources($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM natural_ressources");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
 
    }
    public function delete_ressources($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM natural_ressources");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}