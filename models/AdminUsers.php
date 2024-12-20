<?php 
require_once 'Model.php';

class Users extends Model {

    public function __construct($table){
        parent::__construct($table);
    }

    // Requête pour récupérer certains éléménts de l'utilisateur connecté
    public function get_user_by_id($user_id) {
        $sql = "SELECT firstname, lastname, mail FROM users WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Requête pour récupérer les utilisateurs selon leur rôle
    public function get_users_by_role($role) {
        $sql = "SELECT * FROM users WHERE role = :role";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':role', $role, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Requête pour récupérer tous les administrateurs dans la base de données
    public function get_admin($user_id = null){
        if ($user_id) {
            // Récupérer un administrateur spécifique
            $sql = "SELECT * FROM users WHERE role = :role AND user_id = :user_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':role', 2, PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        } else {
            // Récupérer tous les administrateurs
            $sql = "SELECT * FROM users WHERE role = :role";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':role', 2, PDO::PARAM_STR);
        }
        
        $stmt->execute();
        return $user_id ? $stmt->fetch(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    // Méthode pour supprimer un utilisateur spécifique par son ID
    public function delete($user_id){
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        return $stmt->execute(); // Retourne directement le résultat de l'exécution
    }

    // Méthode pour créer un administrateur
    public function create_admin($lastname, $firstname, $mail, $password, $phone, $address, $city, $zipcode){
        // Obtenir la date actuelle au format 'Y-m-d H:i:s'
        $registration_date = date('Y-m-d H:i:s');
        $role = 2; // Rôle d'administrateur
        
        $sql = "INSERT INTO users 
                (role, lastname, firstname, mail, password, phone, address, city, zipcode, registration_date) 
                VALUES
                (:role, :lastname, :firstname, :mail, 
                :password, :phone, :address, :city, :zipcode, 
                :registration_date)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':role', $role, PDO::PARAM_INT);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':zipcode', $zipcode, PDO::PARAM_INT);
        $stmt->bindParam(':registration_date', $registration_date, PDO::PARAM_STR);
        
        return $stmt->execute(); // Retourne directement le résultat de l'exécution
    }

    // Mettre à jour un utilisateur
    public function update_admin($user_id, $lastname, $firstname, $mail, $phone, $address, $city, $zipcode, $password = null) {
        // Construire la requête SQL
        $sql = "UPDATE users SET lastname = :lastname, firstname = :firstname, mail = :mail, 
                phone = :phone, address = :address, city = :city, zipcode = :zipcode";

        // Ajouter le mot de passe à la requête seulement s'il est fourni
        if ($password) {
            $sql .= ", password = :password";
        }

        $sql .= " WHERE user_id = :user_id";
        
        $stmt = $this->pdo->prepare($sql);

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
