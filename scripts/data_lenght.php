<?php 
include '../class/connectBDD.php';
include '../request/request.php';

// Instancier la classe ConnectBDD et obtenir la connexion PDO
$connectBDDInstance = new ConnectBDD();
$connectBDD = $connectBDDInstance->connectBDD();

// Si ce fichier est appelé directement, afficher les résultats
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json; charset=utf-8'); // Indique que le contenu est du JSON
    
    // Récupérer la difficulté depuis les paramètres GET
    $km = $_GET['length_km'] ?? 0;

    // Appeler la fonction avec la difficulté
    $data = get_data_length($connectBDD, $km);
    
    // Renvoyer les données JSON
    echo $data;
}
?>