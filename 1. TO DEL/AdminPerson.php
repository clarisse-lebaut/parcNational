<?php 
require_once __DIR__ . '/../config/connectBDD.php';

class Users {

    // Requête pour récupérer tous les utilisateurs dans la base de données
    public function get_users($bdd){
        $sql = "SELECT * FROM users WHERE role = :role";
        $stmt = $bdd->prepare($sql);
        $stmt->bindValue(':role', 'user', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count_users($bdd) {
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM users WHERE role = :role");
        $stmt->bindValue(':role', 'user', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour supprimer un utilisateur spécifique par son ID
    public function delete_user($bdd, $user_id){
        $sql = "DELETE FROM users WHERE id = :id"; // On suppose que la table s'appelle 'users' et qu'il y a une colonne 'id'
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        if($stmt->execute()){
            return true; // Retourne true si la suppression s'est bien passée
        } else {
            return false; // Retourne false en cas d'erreur
        }
    }
}


class Admin {
    public function get_admin($bdd){
        $sql = "SELECT * FROM users WHERE role = :role";
        $stmt = $bdd->prepare($sql);
        $stmt->bindValue(':role', 'admin', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);        
    }
    public function count_admin($bdd) {
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM users WHERE role = :role");
        $stmt->bindValue(':role', 'admin', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Méthode pour supprimer un utilisateur spécifique par son ID
    public function delete_admin($bdd, $user_id){
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        if($stmt->execute()){
            return true; // Retourne true si la suppression s'est bien passée
        } else {
            return false; // Retourne false en cas d'erreur
        }
    }
}