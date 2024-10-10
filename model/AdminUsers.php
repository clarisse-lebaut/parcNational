<?php 
require_once __DIR__ . '/../config/connectBDD.php';

class Users {
    // Requête pour récupérer tous les utilisateurs dans la base de données
    public function get_users($bdd){
        $sql = "SELECT * FROM users WHERE role = :role";
        $stmt = $bdd->prepare($sql);
        $stmt->bindValue(':role', 2, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Requête pour récupérer tous les administrateurs dans la base de données
    public function get_admin($bdd, $user_id = null){
        if ($user_id) {
            // Récupérer un administrateur spécifique
            $sql = "SELECT * FROM users WHERE role = :role AND user_id = :user_id";
            $stmt = $bdd->prepare($sql);
            $stmt->bindValue(':role', 1, PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        } else {
            // Récupérer tous les administrateurs
            $sql = "SELECT * FROM users WHERE role = :role";
            $stmt = $bdd->prepare($sql);
            $stmt->bindValue(':role', 1, PDO::PARAM_STR);
        }
        
        $stmt->execute();
        return $user_id ? $stmt->fetch(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour compter les utilisateurs
    public function count_users($bdd) {
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM users WHERE role = :role");
        $stmt->bindValue(':role', 'user', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour compter les admins
    public function count_admin($bdd) {
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM users WHERE role = :role");
        $stmt->bindValue(':role', 'admin', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour supprimer un utilisateur spécifique par son ID
    public function delete($bdd, $user_id){
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        } else {
            return false; 
        }
    }

    // Méthode pour créer un administrateur
    public function create_admin($bdd, $lastname, $firstname, $mail, $password, $phone, $address, $city, $zipcode, $registration_date){
        // Obtenir la date actuelle au format 'Y-m-d H:i:s'
        $registration_date = date('Y-m-d H:i:s');
        $role = 'admin';
        
        $sql = "INSERT INTO users 
                (role, lastname, firstname, mail, password, phone, address, city, zipcode, registration_date) 
                VALUES
                (:role, :lastname, :firstname, :mail, 
                :password, :phone, :address, :city, :zipcode, 
                :registration_date)";
        $stmt = $bdd->prepare($sql);

        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':zipcode', $zipcode, PDO::PARAM_INT);
        $stmt->bindParam(':registration_date', $registration_date, PDO::PARAM_STR);
        
        if($stmt->execute()){
            return true;
        } else {
            return false; 
        }
    }

    // Mettre à jour un utilisateur
    public function update_admin($bdd, $user_id, $lastname, $firstname, $mail, $phone, $address, $city, $zipcode, $password = null) {
        // Construire la requête SQL
        $sql = "UPDATE users SET lastname = :lastname, firstname = :firstname, mail = :mail, 
                phone = :phone, address = :address, city = :city, zipcode = :zipcode";

        // Ajouter le mot de passe à la requête seulement s'il est fourni
        if ($password) {
            $sql .= ", password = :password";
        }

        $sql .= " WHERE user_id = :user_id";
        
        $stmt = $bdd->prepare($sql);

        // Lier les paramètres
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':zipcode', $zipcode, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        // Lier le mot de passe seulement s'il est fourni
        if ($password) {
            $stmt->bindParam(':password', password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
        }

        // Exécuter la requête
        return $stmt->execute();
    }
}
