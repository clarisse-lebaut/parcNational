<?php 
include '../class/connectBDD.php';
include '../request/request.php';

// Instancier la classe ConnectBDD et obtenir la connexion PDO
$connectBDDInstance = new ConnectBDD();
$connectBDD = $connectBDDInstance->connectBDD();

// Si ce fichier est appelé directement, afficher les résultats
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json; charset=utf-8'); // Indique que le contenu est du JSON
    
    // Récupérer les paramètres depuis les GET (s'ils existent)
    $difficulty = $_GET['difficulty'] ?? ''; // Valeur par défaut à null
    $km = $_GET['length_km'] ?? ''; // Valeur par défaut à null
    $status = $_GET['status'] ?? ''; // Valeur par défaut à null
    $time = $_GET['time'] ?? ''; // Valeur par défaut à null

    // Récupérer les données en fonction des paramètres
    $data = get_all_data($connectBDD, $difficulty, $km, $status, $time);
    
    // Renvoyer les données combinées au format JSON
    echo json_encode($data);
}
?>
