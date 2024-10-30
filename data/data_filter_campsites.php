<?php
require_once '../models/Model.php';
require_once '../controllers/campsiteController.php';

// Instancier la classe Model avec le nom de la table des sentiers
$campsiteModel = new CampsiteModel('campsites'); // Remplacez 'trails' par le nom correct de votre table

// Si ce fichier est appelé directement, afficher les résultats
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json; charset=utf-8'); // Indique que le contenu est du JSON

    // Récupérer les données en fonction des paramètres
    $data = $campsiteModel->getAllCampsites();

    // Renvoyer les données combinées au format JSON
    echo json_encode($data);
}
?>
