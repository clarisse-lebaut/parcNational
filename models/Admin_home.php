<?php 
require_once __DIR__ . '/../config/connectBDD.php';


class AdminData {
    //+ Requête pour avoir tous les utilisateurs peut importe le rôle
    public function get_user($bdd){
        $sql = "SELECT * FROM users";
        $stmt = $bdd->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function count_users($bdd) {
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM users");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Cela devrait retourner un tableau avec 'total'
    }
    // Nouvelle méthode pour compter les sentiers
    public function count_trails($bdd) {
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM trails"); // Assurez-vous que la table est correcte
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Cela devrait retourner un tableau avec 'total'
    }

}