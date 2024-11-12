<?php

require_once ('Model.php');

class Log extends Model{
    public function __construct($table){
       parent:: __construct($table); 
    }
    public function saveLog($url){
        $sql = 'INSERT INTO logs(action, ip) VALUES(?,?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$url, $_SERVER['REMOTE_ADDR']]);
    }
}
