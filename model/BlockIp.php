<?php

require_once ('Model.php');
class BlockIp extends Model{
    public function __construct($table){
        parent::__construct($table);
    }
    public function saveIp($ip){
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