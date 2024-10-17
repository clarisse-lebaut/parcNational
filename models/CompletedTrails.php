<?php

require_once 'Model.php';

class CompletedTrails extends Model{

    public function addCompletedTrail($trailId){
        $sql = 'INSERT INTO completed_trails (user_id, trail_id) VALUES(?,?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$_SESSION['user_id'], $trailId]);
    }

    public function deleteCompletedTrail($trailId){
        $sql = 'DELETE FROM completed_trails WHERE user_id = ? AND trail_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$_SESSION['user_id'], $trailId]);
    }

    public function getCompletedTrailByUser(){
        $sql = 'SELECT c.trail_id, t.image, t.name FROM completed_trails c
        JOIN trails t ON c.trail_id = t.trail_id
        WHERE c.user_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$_SESSION['user_id']]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getCompletedTrail($trailId){
        $sql = 'SELECT * FROM completed_trails WHERE user_id = ? AND trail_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$_SESSION['user_id'], $trailId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}