<?php 
require_once 'Model.php';

class AdminData extends Model {
    public function __construct($table){
        parent::__construct($table);
    }
    public function get_user(){
        $sql = "SELECT * FROM users";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour compter les utilisateurs
    public function count_users() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM users WHERE role = :role");
        $stmt->bindValue(':role', 1, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour compter les admins
    public function count_admin() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM users WHERE role = :role");
        $stmt->bindValue(':role', 2, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function count_trails() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM trails");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function count_campsites(){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM campsite");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function count_ressources(){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM natural_ressources");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function count_rapports(){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM reports");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function count_articles(){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM news");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function count_ships(){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM membership");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}