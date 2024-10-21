<?php 
require_once 'Model.php';

class News extends Model{

    public function __construct($table)
    {
        parent::__construct($table); // Appel au constructeur de Model pour initialiser la connexion
    }

    public function get_news(){
        $sql = "SELECT * FROM news";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}