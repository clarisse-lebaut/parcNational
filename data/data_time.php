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
    // Pour récupérer l'heure, il faut mettre le format avec le chiffre dans un format string, pas int
    $time = $_GET['time'] ?? '00:30:00'; // On donne une valeur par défaut pour toujours avoir un retour si non spécifié

    // Appeler la fonction avec la difficulté
    $data = get_data_time($connectBDD, $time);
    
    // Renvoyer les données JSON
    echo $data;
}
?>
