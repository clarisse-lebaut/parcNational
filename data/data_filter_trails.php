<?php
require_once '../models/Model.php';
require_once '../controllers/TrailsController.php';

// Instancier la classe Model avec le nom de la table des sentiers
$trailsModel = new Trails('trails'); // Remplacez 'trails' par le nom correct de votre table

// Si ce fichier est appelé directement, afficher les résultats
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json; charset=utf-8'); // Indique que le contenu est du JSON

    // Récupérer les paramètres depuis les GET, les nettoyer et les valider
    $difficulty = isset($_GET['difficulty']) ? htmlspecialchars($_GET['difficulty']) : ''; // Nettoyer la difficulté
    $km = isset($_GET['length_km']) && is_numeric($_GET['length_km']) ? (int) $_GET['length_km'] : null; // S'assurer que km est un entier
    $status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : ''; // Nettoyer le statut
    $time = isset($_GET['time']) ? htmlspecialchars($_GET['time']) : ''; // Nettoyer le temps

    // Récupérer les données en fonction des paramètres
    $data = $trailsModel->get_filtered_trails($difficulty, $km, $status, $time); // Appel correct ici

    // Renvoyer les données combinées au format JSON
    echo json_encode($data);
}
?>
