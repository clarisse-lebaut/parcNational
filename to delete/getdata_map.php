<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

class ConnectBDD
{
    public function connectBDD()
    {
        try {
            $dsn = "mysql:host=localhost;dbname=nationalpark;charset=utf8";
            $username = "root";
            $password = "";

            $connectBDD = new PDO($dsn, $username, $password);
            $connectBDD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connectBDD;

        } catch (PDOException $e) {
            echo 'Erreur PDO : ' . $e->getMessage();
            die();
        }
    }
}

function getGeoJson()
{
    $database = new ConnectBDD();
    $pdo = $database->connectBDD();

    // Requête SQL pour récupérer les coordonnées triées
    $sql = "SELECT part_number, coordinate_number, mystery_number, longitude, latitude
            FROM map
            ORDER BY part_number, coordinate_number, mystery_number";

    $stmt = $pdo->query($sql);

    // Structure pour contenir tous les multipolygones
    $multipolygons = [];
    $currentPolygon = [];  // Pour contenir le polygone courant
    $currentPart = null;   // Partie courante
    $currentPartNumber = null;  // Numéro de la partie courante

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $partNumber = $row['part_number'];

        // Si nous changeons de partie, sauvegardons la partie actuelle
        if ($currentPartNumber !== null && $currentPartNumber !== $partNumber) {
            // Si la partie actuelle n'est pas vide et qu'elle n'est pas déjà fermée
            if (!empty($currentPart) && $currentPart[0] !== end($currentPart)) {
                $currentPart[] = $currentPart[0]; // Fermeture de l'anneau
            }
            // Ajouter la partie fermée au polygone courant
            $currentPolygon[] = $currentPart;
            // Réinitialiser la partie courante
            $currentPart = [];
        }

        // Ajouter les coordonnées à la partie courante
        $currentPart[] = [(float)$row['longitude'], (float)$row['latitude']];
        $currentPartNumber = $partNumber;
    }

    // Ajouter la dernière partie et le dernier polygone si nécessaire
    if (!empty($currentPart)) {
        if ($currentPart[0] !== end($currentPart)) {
            $currentPart[] = $currentPart[0]; // Fermer la dernière partie
        }
        $currentPolygon[] = $currentPart; // Ajouter la dernière partie au polygone
    }

    if (!empty($currentPolygon)) {
        $multipolygons[] = $currentPolygon; // Ajouter le dernier polygone au MULTIPOLYGON
    }

    // Créer le GeoJSON avec des MULTIPOLYGON
    $geojson = [
        'type' => 'FeatureCollection',
        'features' => [
            [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'MultiPolygon',
                    'coordinates' => $multipolygons
                ],
                'properties' => [
                    // Ici, on peut ajouter d'autres propriétés si nécessaire
                ]
            ]
        ]
    ];

    echo json_encode($geojson);
}

getGeoJson();
?>