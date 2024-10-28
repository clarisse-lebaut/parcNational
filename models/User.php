<?php

require_once 'Model.php';

class User extends Model{
    public function __construct($table){
        parent::__construct($table);
    }
    /*public function saveUser($data){
        //Database keys
        $sql = 'INSERT INTO users (role, lastname, firstname, mail, password, phone, address, city, zipcode) values (?,?,?,?,?,?,?,?,?)';
        $stmt = $this->pdo->prepare($sql);
        //"names" from Form
        $stmt->execute([1, $data['lastname'], $data['firstname'], $data['email'], password_hash($data['password'], PASSWORD_BCRYPT), $data['phone'], $data['adress'], $data['city'], $data['zipcode']]);
    }*/
    
    public function saveUserWithActivation($userData, $token){
        $sql = 'INSERT INTO users (role, lastname, firstname, mail, password, phone, address, city, zipcode, activation_token, is_active) VALUES(?,?,?,?,?,?,?,?,?,?,?)';
        $stmt = $this->pdo->prepare($sql);
        $hashedPassword = password_hash($userData['password'], PASSWORD_BCRYPT);
        $activationToken = $token;
        $isActive = 0;
        $stmt->execute([ 1, $userData['lastname'], $userData['firstname'], $userData['email'], $hashedPassword, $userData['phone'], $userData['adress'], $userData['city'], $userData['zipcode'], $activationToken, $isActive]);
    }

    public function activateUser($token){
        $sql = 'SELECT users SET is_active = ?, activation_token = NULL WHERE activation_token = ?';
        $stmt->prepare->pdo($sql);
        $isActive = 1;

        return $stmt->execute([$isActive, $token]);
    }

    public function isUserActive($email){
        $sql = 'SELECT from users WHERE email = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        return $user && $user['is_active'] ==  1;
        }

    public function userExists($email) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM " . $this->table . " WHERE mail = :mail");
        $stmt->execute([':mail' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    public function getUserByEmail($email){
        $sql = ' SELECT * FROM users WHERE mail = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function getById($userId){
        $sql = 'SELECT * FROM users WHERE user_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByName($name){
        $sql = 'SELECT * FROM users WHERE lastname = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveUserFromGoogle($data){
        var_dump($data);
        $sql = ' INSERT INTO users (role, lastname, firstname, mail, google_id) values (?,?,?,?,?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([1, $data->family_name, $data->given_name, $data->email, $data->sub]);//names from google

    }
    public function getByGoogleId($googleId){
        $sql = 'SELECT * FROM users WHERE google_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$googleId]);
        return $stmt->fetch();
    }

    public function saveUserFromFacebook($data){
        $name = $data->name;
        $nameArray = explode(' ', $name);//The explode function is used to convert a string into an array.
        $sql = 'INSERT INTO users(role, mail, firstname, lastname, facebook_id) values(?,?,?,?,?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([1, $data->email, $nameArray[0], $nameArray[1], $data->id]);//The data from json_decode returns an object, not an array, which is why we refer to it in this way.
    }

    public function getByFacebookId($facebookId){
        $sql = 'SELECT * FROM users WHERE facebook_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$facebookId]);
        return $stmt->fetch();
    }

    public function savePasswordResetToken($userId, $token, $expiry ){
        $sql = 'INSERT INTO password_resets (user_id, token, expires_at) VALUES (?,?,?)
        ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId, $token, $expiry]);
    }

    public function getResetToken($token) {
        $sql = 'SELECT user_id, expires_at FROM password_resets WHERE token = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updatePassword($userId, $newPassword){
        $sql = ' UPDATE users SET password = ? WHERE user_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$newPassword, $userId]);
    }

    public function deleteResetToken($token){
        $sql = ' DELETE FROM password_resets WHERE token = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$token]);
    }

    public function updateUser($userId, $data){
    $sql = 'UPDATE users SET firstname = ?, lastname = ?, mail = ?, phone = ?, address = ?, city = ?, zipcode = ?, password = ? WHERE user_id = ?';
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$data['firstname'], $data['lastname'], $data['mail'], $data['phone'], $data['address'], $data['city'], $data['zipcode'], $data['password'], $userId]);
    }

    public function getReservationsByUser($user_id) {
        $query = $this->pdo->prepare('SELECT r.*, c.name AS campsite_name, c.image AS campsite_image
                                     FROM reservations r 
                                     JOIN campsite c ON r.campsite_id = c.campsite_id 
                                     WHERE r.user_id = :user_id 
                                     ORDER BY r.reservation_date DESC');
        $query->bindParam(':user_id', $user_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteReservationById($reservation_id){
        $sql = 'DELETE FROM reservations WHERE user_id = ? and reservation_id = ?';
        $stmt =  $this->pdo->prepare($sql);
        $stmt->execute($_SESSION['user_id'], [$reservation_id]);
    }
}
