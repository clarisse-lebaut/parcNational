<?php 
require_once '../models/Model.php';
require_once '../controllers/TrailsController.php';

//! Instancier la classe Trails et obtenir les données des sentiers
$trailsModel = new Trails('landmarks_trails'); // Passer la connexion à Trails

// Si ce fichier est appelé directement, afficher les résultats
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json; charset=utf-8'); // Indique que le contenu est du JSON
    
    // Appeler la fonction get_map_data pour récupérer les données de la map
    $data = $trailsModel->get_map_landmarks_data();
    
    // S'assurer que les données sont présentes
    if ($data && isset($data['type']) && $data['type'] === 'FeatureCollection') {
        // Encoder en JSON avec JSON_PRETTY_PRINT pour un affichage lisible
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    } else {
        // Gérer les erreurs ou données manquantes
        echo json_encode(["error" => "Les données GeoJSON sont manquantes ou invalides."]);
    }
}
?>