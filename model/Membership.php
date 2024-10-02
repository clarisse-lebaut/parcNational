<?php

require_once ('Model.php');

class Membership extends Model{
    public function __construct($table){
        parent::__construct($table);
    }
    public function saveNewMembership($startDate, $endDate, $user_id, $status = 'active'){
        $sql = 'INSERT INTO membership(delivery_date, expiry_date, user_id, status) VALUES(?,?,?, ?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$startDate, $endDate, $user_id, $status]);
        if ($stmt->errorCode() !== '00000') {
            error_log("Erreur d'enregistrement de l'adhésion: " . implode(', ', $stmt->errorInfo()));
        }
    }
    public function getMembershipByUserId($user_id){
        $sql = " SELECT * FROM membership WHERE user_id = ? AND status = 'active' LIMIT 1 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getActiveMembership($user_id){
        $sql = ' SELECT * FROM membership WHERE user_id = ? AND expiry_date > NOW() LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}