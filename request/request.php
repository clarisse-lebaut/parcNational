<?php
function get_all_trails($connectBDD): array {
    $requeteSQL = "SELECT * from trails";
    $getAllData = $connectBDD->prepare($requeteSQL);
    $getAllData->execute();
    $trails = $getAllData->fetchAll(PDO::FETCH_ASSOC);
    return $trails;
}

function get_trails_id($connectBDD, $id) : array {
    $sql = "SELECT * FROM trails WHERE trail_id = :id";
    $stmt = $connectBDD->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_trails_time($connectBDD, $time) : bool{
    $sql = "SELECT * FROM trails WHERE time = :time";
    $stmt = $connectBDD->prepare($sql);
    $stmt->bindParam(':time', $time, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_trails_km($connectBDD, $km) {
    $sql = "SELECT * FROM trails WHERE length_km = :length_km";
    $stmt = $connectBDD->prepare($sql);
    $stmt->bindParam(':length_km', $km, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_trails_description($connectBDD, $description) : string{
    $sql = "SELECT * FROM trails WHERE description = :description";
    $stmt = $connectBDD->prepare($sql);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_trails_difficulty($connectBDD): array {
    $sql = "SELECT * FROM trails WHERE difficulty = :difficulty";
    $stmt = $connectBDD->prepare($sql);
    $stmt->bindParam(':difficulty', $difficulty, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_trails_status($connectBDD, $state) : bool{
    $sql = "SELECT * FROM trails WHERE status = :status";
    $stmt = $connectBDD->prepare($sql);
    $stmt->bindParam('status', $state, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_trails_landmarks($connectBDD, $trail_id) {
    $sql = "SELECT lt.landmark_id, l.name 
        FROM landmarks_trails lt
        JOIN landmarks l ON lt.landmark_id = l.landmark_id
        WHERE lt.trail_id = :trail_id
    ";
    
    $stmt = $connectBDD->prepare($sql);
    $stmt->bindParam(':trail_id', $trail_id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_map_data($connectBDD){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    header('Content-Type: application/json');
    $sql = "SELECT part_number, coordinate_number, mystery_number, longitude, latitude
            FROM map
            ORDER BY part_number, coordinate_number, mystery_number";
    $stmt = $connectBDD->prepare($sql);
    $stmt->execute();  // Exécuter la requête

    // Structure pour contenir tous les multipolygones
    $multipolygons = [];
    $currentPolygon = [];  // Pour contenir le polygone courant
    $currentPart = [];   // Partie courante
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

    return $geojson;  // Ne pas oublier de retourner le GeoJSON
}

function get_mapTrails_data($connectBDD) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    header('Content-Type: application/json');

    // Requête SQL pour récupérer tous les sentiers
    $sql = "SELECT t.trail_id, t.name, pg.part_number, pg.coordinate_number, pg.longitude, pg.latitude
            FROM trails t
            JOIN position_geographic pg ON t.trail_id = pg.trail_id
            ORDER BY t.trail_id, pg.part_number, pg.coordinate_number";

    $stmt = $connectBDD->prepare($sql);
    $stmt->execute();

    // Structure pour contenir tous les sentiers
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
                'trail_id' => $trailId, // Ajouter l'ID du sentier
                'name' => $row['name'],
                'linestrings' => []
            ];
        }
    }

    // Ajouter la dernière LineString si nécessaire
    if (!empty($currentLineString)) {
        $trails[$currentTrailId]['linestrings'][] = $currentLineString;
    }

    // Créer le GeoJSON
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
                'name' => $trail['name'],
                'trail_id' => $trail['trail_id']  // Ajouter l'ID du sentier ici
            ]
        ];
    }

    return $geojson;  // Retourner le GeoJSON
}

function get_mapLandmarks_data($connectBDD) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    header('Content-Type: application/json');

    // Récupérer tous les points d'intérêt avec l'ID du sentier
    $sql = "SELECT lt.landmark_id, l.name, lt.trail_id, l.longitude, l.latitude 
            FROM landmarks l
            JOIN landmarks_trails lt ON l.landmark_id = lt.landmark_id";

    $stmt = $connectBDD->prepare($sql);
    $stmt->execute();

    $pois = [];
    while ($poi = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pois[] = [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [(float)$poi['longitude'], (float)$poi['latitude']]
            ],
            'properties' => [
                'landmark_id' => $poi['landmark_id'],
                'trail_id' => $poi['trail_id'], // Inclure l'ID du sentier
                'name' => $poi['name']
            ]
        ];
    }

    // Créer le GeoJSON
    $geojson = [
        'type' => 'FeatureCollection',
        'features' => $pois
    ];

    return $geojson;  // Retourner le GeoJSON
}









?>
