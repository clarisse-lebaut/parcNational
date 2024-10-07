<?php 
require_once __DIR__ . '/../config/connectBDD.php';

class News {
    //+ Requête pour récupérer les données dans la base de donnée
    public function get_news($bdd){
        $sql = "SELECT * FROM news";
        $stmt = $bdd->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}