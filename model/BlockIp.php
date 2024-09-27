<?php

require_once ('Model.php');
class BlockIp extends Model{
    public function __construct($table){
        parent::__construct($table);
    }
    public function isIpBlocked($ip){
        $sql = 'SELECT COUNT(*) FROM block_ips WHERE ip = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$ip]);
        return $stmt->fetchColumn() > 0;
    }
    
    public function saveIp($ip){
        if ($this->isIpBlocked($ip)) {
            echo 'This IP is already blocked!';
            return;
        }
        $sql = ' INSERT INTO block_ips(ip) values(?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$ip]);
    }
    public function getAll(){
        $sql = ' SELECT * FROM block_ips';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }
}