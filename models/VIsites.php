<?php 
require_once __DIR__ . '/Model.php';

class Visites extends Model {

    public function __construct() {
        parent::__construct('visites'); 
    }
    
    // 1. Récupérer toutes les visites (si besoin pour affichage global)
    public function get_visite(){
        $sql = "SELECT * FROM visites";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Incrémenter le compteur pour une page donnée
    public function incrementerCompteur($page) {
        // Vérifier si la page existe déjà dans la table
        $sql = "SELECT compteur FROM visites WHERE page = :page";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['page' => $page]);
        $result = $stmt->fetch();

        if ($result) {
            // Si la page existe, on incrémente le compteur
            $sql = "UPDATE visites SET compteur = compteur + 1 WHERE page = :page";
        } else {
            // Sinon, on insère un nouvel enregistrement avec compteur = 1
            $sql = "INSERT INTO visites (page, compteur) VALUES (:page, 1)";
        }

        // Exécuter la requête préparée
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['page' => $page]);
    }

    // Obtenir le compteur pour une page spécifique
    public function obtenirCompteur($page) {
        $sql = "SELECT compteur FROM visites WHERE page = :page";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['page' => $page]);
        $result = $stmt->fetch();
        
        return $result ? $result['compteur'] : 0;
    }
}
