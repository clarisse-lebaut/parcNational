<?php

require_once ('Model.php');

class Membership extends Model{
    public function __construct($table){
        parent::__construct($table);
    }
    public function saveNewMembership($user_id, $name, $startDate, $endDate, $email = null, $status = 'active', ){
        $randomID = bin2hex(random_bytes(4));
        $sql = 'INSERT INTO membership( user_id, lastname, delivery_date, expiry_date, mail, random_id, status) VALUES(?,?,?,?,?,?,?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id, $name, $startDate, $endDate, $email, $randomID, $status]);
        if ($stmt->errorCode() !== '00000') {
            error_log("Erreur d'enregistrement de l'adhésion: " . implode(', ', $stmt->errorInfo()));
        }
        return $randomID;
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