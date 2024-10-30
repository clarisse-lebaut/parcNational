<?php 
require_once __DIR__ . '/Model.php'; // Utilisation de la classe Model

class News extends Model {

    public function __construct() {
        parent::__construct('news'); 
    }
    
    // 1. Récupérer toutes les actualités
    public function get_news(){
        $sql = "SELECT * FROM news";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // 2. Récupérer une actualité par ID
    public function get_news_by_id($id){
        $sql = "SELECT * FROM news WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Liaison de l'ID
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Utiliser fetch() au lieu de fetchAll() pour un seul résultat
    }
    
    // 3. Créer une nouvelle actualité
    public function createNews($title, $published_date, $published_time, $picture, $content) {
        $query = $this->pdo->prepare('INSERT INTO news (title, published_date, published_time, picture, content) 
                                     VALUES (:title, :published_date, :published_time, :picture, :content)');
        $query->bindParam(':title', $title);
        $query->bindParam(':published_date', $published_date);
        $query->bindParam(':published_time', $published_time);
        $query->bindParam(':picture', $picture);
        $query->bindParam(':content', $content);
        return $query->execute();
    }

    // 4. Mettre à jour une actualité
    public function updateNews($id, $title, $published_date, $published_time, $picture, $content) {
        $query = $this->pdo->prepare('UPDATE news SET title = :title, published_date = :published_date, published_time = :published_time, 
                                    picture = :picture, content = :content WHERE id = :id');
        $query->bindParam(':title', $title);
        $query->bindParam(':published_date', $published_date);
        $query->bindParam(':published_time', $published_time);
        $query->bindParam(':picture', $picture);
        $query->bindParam(':content', $content);
        $query->bindParam(':id', $id); // Correction ici
        return $query->execute();
    }

    // 5. Supprimer une actualité
    public function deleteNews($id) {
        $query = $this->pdo->prepare('DELETE FROM news WHERE id = :id');
        $query->bindParam(':id', $id); // Correction ici
        return $query->execute();
    }

}
