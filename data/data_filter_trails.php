<?php
include '../config/connectBDD.php';
include '../controllers/TrailsController.php';

// Instancier la classe ConnectBDD et obtenir la connexion PDO
$connectBDDInstance = new ConnectBDD();
$connectBDD = $connectBDDInstance->bdd;

// Instancier la classe Trails et obtenir les données des sentiers
$trailsModel = new Trails($connectBDD); // Passer la connexion à Trails

// Si ce fichier est appelé directement, afficher les résultats
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json; charset=utf-8'); // Indique que le contenu est du JSON

    // Récupérer les paramètres depuis les GET, les nettoyer et les valider
    $difficulty = isset($_GET['difficulty']) ? htmlspecialchars($_GET['difficulty']) : ''; // Nettoyer la difficulté
    $km = isset($_GET['length_km']) && is_numeric($_GET['length_km']) ? (int) $_GET['length_km'] : ''; // S'assurer que km est un entier
    $status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : ''; // Nettoyer le statut
    $time = isset($_GET['time']) ? htmlspecialchars($_GET['time']) : ''; // Nettoyer le temps

    // Récupérer les données en fonction des paramètres
    $data = $trailsModel->get_all_data($connectBDD, $difficulty, $km, $status, $time); // Appel correct ici

    // Renvoyer les données combinées au format JSON
    echo json_encode($data);
}
?>