<?php

require_once ('Model.php');

class Membership extends Model{
    public function __construct($table){
        parent::__construct($table);
    }
    public function saveNewMembership($user_id, $name, $startDate, $endDate, $membershipName, $status = 'active', $email = null){
        $randomID = bin2hex(random_bytes(4));
        $sql = 'INSERT INTO membership( user_id, lastname, delivery_date, expiry_date, random_id, memberships_name, status, mail) VALUES(?,?,?,?,?,?,?,?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $name, $startDate, $endDate, $randomID, $membershipName, $status, $email]);
        if ($stmt->errorCode() !== '00000') {
            error_log("Erreur d'enregistrement de l'adhésion: " . implode(', ', $stmt->errorInfo()));
        }
        return $randomID;
    }
    public function getMembershipByUserId($user_id){
        $sql = "SELECT * FROM membership WHERE user_id = ? AND status = 'active' LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllActiveMemberships($userId) {
        $query = "SELECT users.lastname AS user_name, users.mail AS user_email, membership.memberships_name AS membership_name, membership.delivery_date, membership.expiry_date, membership.status
                  FROM membership
                  INNER JOIN users ON membership.user_id = users.user_id
                  WHERE membership.status = 'active' AND membership.user_id = :user_id"; 
    
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    public function addMembership($membershipsName, $duration, $price) {
        $sql = 'INSERT INTO membership (memberships_name, duration, price) VALUES (?, ?, ?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$membershipsName, $duration, $price]);
    }
    
    public function updateMembership($membershipsName, $duration, $price, $membershipId) {
        $sql = 'UPDATE membership SET memberships_name = ?, duration = ?, price = ? WHERE card_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$membershipsName, $duration, $price, $membershipId]);
    }
    
    public function deleteMembership($membershipId) {
        $sql = 'DELETE FROM membership WHERE card_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$membershipId]);
    }
    
    public function getAllMemberships() {
        $sql = 'SELECT * FROM membership WHERE memberships_name IS NOT NULL AND memberships_name != "" AND duration > 0 AND price > 0';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
    
    
    public function getMembershipById($membershipId) {
        $sql = 'SELECT * FROM membership WHERE card_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$membershipId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllActiveMembershipsForAdmin() {
        $query = "SELECT users.lastname AS user_name, users.mail AS user_email, membership.memberships_name AS membership_name, membership.delivery_date, membership.expiry_date, membership.status
                  FROM membership
                  INNER JOIN users ON membership.user_id = users.user_id
                  WHERE membership.status = 'active'";
        
        $result = $this->pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        error_log(print_r($result, true));
        
        return $result;
    }

    public function getTotalMemberships() {
        $sql = 'SELECT COUNT(*) as total FROM membership';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    

}


    