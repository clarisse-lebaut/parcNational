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
    
    $sql = "SELECT part_number, coordinate_number, longitude, latitude
            FROM position_geographique
            ORDER BY part_number, coordinate_number";

    $stmt = $pdo->query($sql);

    // Structure pour contenir toutes les MultiLineStrings
    $multilinestrings = [];
    $currentLineString = [];  // Pour contenir la LineString courante
    $currentPartNumber = null;  // Numéro de la partie courante

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $partNumber = $row['part_number'];

        // Si nous changeons de partie, sauvegardons la partie actuelle
        if ($currentPartNumber !== null && $currentPartNumber !== $partNumber) {
            if (!empty($currentLineString)) {
                $multilinestrings[] = $currentLineString;  // Ajouter la LineString au MultiLineString
            }
            $currentLineString = []; // Réinitialiser la LineString courante
        }

        // Ajouter les coordonnées à la LineString courante
        $currentLineString[] = [(float)$row['longitude'], (float)$row['latitude']];
        $currentPartNumber = $partNumber;
    }

    // Ajouter la dernière LineString si nécessaire
    if (!empty($currentLineString)) {
        $multilinestrings[] = $currentLineString; // Ajouter la dernière LineString au MultiLineString
    }

    // Créer le GeoJSON avec des MultiLineString
    $geojson = [
        'type' => 'FeatureCollection',
        'features' => [
            [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'MultiLineString',
                    'coordinates' => $multilinestrings
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