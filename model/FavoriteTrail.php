<?php
require_once 'Model.php';

class FavoriteTrail extends Model{
    public function __construct($table){
        parent::__construct($table);
    }

    public function getFavoriteTrail($trailId){
        $sql = 'SELECT * FROM favorites_trails WHERE user_id = ? AND trail_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$_SESSION['user_id'], $trailId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addFavoriteTrail($trailId){
        $sql = 'INSERT INTO favorites_trails(user_id, trail_id) VALUES(?,?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$_SESSION['user_id'], $trailId]);
    }

    public function deleteFavoriteTrail($trailId){
        $sql = 'DELETE FROM favorites_trails WHERE user_id = ? AND trail_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$_SESSION['user_id'], $trailId]);
    }

}