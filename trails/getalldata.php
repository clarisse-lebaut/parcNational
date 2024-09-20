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
            $dsn = "mysql:host=localhost;dbname=my_map;charset=utf8";
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
    $sql = "SELECT t.trail_id, t.name, pg.part_number, pg.coordinate_number, pg.longitude, pg.latitude
            FROM trail t
            JOIN position_geographique pg ON t.trail_id = pg.trail_id
            ORDER BY t.trail_id, pg.part_number, pg.coordinate_number";

    $stmt = $pdo->query($sql);

    // Structure pour contenir chaque sentier
    $trails = [];
    $currentTrailId = null;
    $currentLineString = [];
    $currentPartNumber = null;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $trailId = $row['trail_id'];
        $partNumber = $row['part_number'];

        // Si nous changeons de sentier, sauvegardons le précédent
        if ($currentTrailId !== null && $currentTrailId !== $trailId) {
            if (!empty($currentLineString)) {
                $trails[$currentTrailId]['linestrings'][] = $currentLineString;
            }
            $currentLineString = [];
            $currentTrailId = $trailId; // Changer de sentier
        }

        // Si nous changeons de partie, ajoutons la ligne courante au sentier
        if ($currentPartNumber !== null && $currentPartNumber !== $partNumber) {
            if (!empty($currentLineString)) {
                $trails[$trailId]['linestrings'][] = $currentLineString;
            }
            $currentLineString = [];
        }

        // Ajouter les coordonnées à la LineString courante
        $currentLineString[] = [(float)$row['longitude'], (float)$row['latitude']];
        $currentPartNumber = $partNumber;
        $currentTrailId = $trailId;

        // Stocker les informations du sentier
        if (!isset($trails[$trailId])) {
            $trails[$trailId] = [
                'name' => $row['name'],
                'linestrings' => []
            ];
        }
    }

    // Ajouter la dernière LineString si nécessaire
    if (!empty($currentLineString)) {
        $trails[$currentTrailId]['linestrings'][] = $currentLineString;
    }

    // Créer le GeoJSON avec des MultiLineString pour chaque sentier
    $geojson = [
        'type' => 'FeatureCollection',
        'features' => []
    ];

    foreach ($trails as $trailId => $trail) {
        $geojson['features'][] = [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'MultiLineString',
                'coordinates' => $trail['linestrings']
            ],
            'properties' => [
                'name' => $trail['name']
            ]
        ];
    }

    echo json_encode($geojson);
}

getGeoJson();
?>
