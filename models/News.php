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
    public function get_news_by_id($id){
        $sql = "SELECT * FROM news WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Liaison de l'ID
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Utiliser fetch() au lieu de fetchAll() pour un seul résultat
    }
}