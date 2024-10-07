<?php
require_once __DIR__ . '/../config/connectBDD.php'; // Assurez-vous que le chemin vers le fichier de connexion est correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['trail_coords'])) {
        $trail_coords = $data['trail_coords'];

        // Établir une connexion à votre base de données
        $dbConnection = new ConnectBDD();

        // Décomposer la chaîne CSV en coordonnées
        $lines = explode("\n", trim($trail_coords)); // Supprime les espaces en début et fin de chaîne
        array_shift($lines); // Retirer la première ligne (en-tête)

        $part_number = 1; // Initialiser le numéro de la partie
        foreach ($lines as $line) {
            $coords = str_getcsv($line); // Divise la ligne en tableau
            if (count($coords) === 2) { // Vérifie que nous avons bien deux valeurs
                $latitude = floatval(trim($coords[0])); // Convertir en nombre flottant
                $longitude = floatval(trim($coords[1])); // Convertir en nombre flottant
                $coordinate_number = $part_number++; // Incrémente le numéro de coordonnée

                // Validation des coordonnées
                if ($latitude < -90 || $latitude > 90) {
                    echo json_encode(["status" => "error", "message" => "Latitude invalide: " . $latitude]);
                    exit; // Arrête le script
                }
                if ($longitude < -180 || $longitude > 180) {
                    echo json_encode(["status" => "error", "message" => "Longitude invalide: " . $longitude]);
                    exit; // Arrête le script
                }

                // Insérer les données dans la base de données
                if ($dbConnection->insertGeographicData(null, 'Type de votre choix', $part_number, $coordinate_number, $longitude, $latitude)) {
                    // L'insertion a réussi
                } else {
                    echo json_encode(["status" => "error", "message" => "Erreur lors de l'insertion des coordonnées."]);
                    exit; // Arrête le script en cas d'erreur
                }
            }
        }

        echo json_encode(["status" => "success", "message" => "Sentier enregistré avec les coordonnées."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Données manquantes."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Méthode non autorisée."]);
}
?>
