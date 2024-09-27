<?php 
require_once __DIR__ . '/../config/connectBDD.php';

class Trails {
//* Requêtes pour le données sur les sentiers
function get_trails_all($connectBDD) {
    $requeteSQL = "SELECT * from trails";
    $getAllData = $connectBDD->prepare($requeteSQL);
    $getAllData->execute();
    $trails = $getAllData->fetchAll(PDO::FETCH_ASSOC);
    return $trails;
}

//* Requêtes pour les détails d'un seul sentier
// Fonction générique pour exécuter des requêtes
function executeQuery($connectBDD, $sql, $params = [], $fetchAll = false) {
    $stmt = $connectBDD->prepare($sql);
    foreach ($params as $key => &$val) {
        $stmt->bindParam($key, $val);
    }
    $stmt->execute();
    return $fetchAll ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetch(PDO::FETCH_ASSOC);
}
// Différentes requête pour récupérer les données une à une et les définirs
function get_trails_id($connectBDD, $id): array {
    $sql = "SELECT * FROM trails WHERE trail_id = :id";
    return executeQuery($connectBDD, $sql, [':id' => $id]);
}
function get_trails_time($connectBDD, $time) {
    $sql = "SELECT * FROM trails WHERE time = :time";
    return executeQuery($connectBDD, $sql, [':time' => $time]);
}
function get_trails_km($connectBDD, $km) {
    $sql = "SELECT * FROM trails WHERE length_km = :length_km";
    return executeQuery($connectBDD, $sql, [':length_km' => $km]);
}
function get_trails_description($connectBDD, $description) {
    $sql = "SELECT * FROM trails WHERE description = :description";
    return executeQuery($connectBDD, $sql, [':description' => $description]);
}
function get_trails_difficulty($connectBDD, $difficulty): array {
    $sql = "SELECT * FROM trails WHERE difficulty = :difficulty";
    return executeQuery($connectBDD, $sql, [':difficulty' => $difficulty], true);
}
function get_trails_status($connectBDD, $state) {
    $sql = "SELECT * FROM trails WHERE status = :status";
    return executeQuery($connectBDD, $sql, [':status' => $state]);
}
function get_trails_info($connectBDD, $news) {
    $sql = "SELECT * FROM trails WHERE infos = :infos";
    return executeQuery($connectBDD, $sql, [':infos' => $news]);
}
function get_trails_access($connectBDD, $access) {
    $sql = "SELECT * FROM trails WHERE acces = :acces";
    return executeQuery($connectBDD, $sql, [':acces' => $access]);
}
function get_trails_landmarks($connectBDD, $trail_id) {
    $sql = "SELECT lt.landmark_id, l.name, l.description, l.location 
            FROM landmarks_trails lt
            JOIN landmarks l ON lt.landmark_id = l.landmark_id
            WHERE lt.trail_id = :trail_id";
    
    return executeQuery($connectBDD, $sql, [':trail_id' => $trail_id], true);
}

//* Requêtes pour le filtre des sentiers
// Fonction pour récupérer la difficuluté, les kilomètres, les status et le temps des sentiers
function get_all_data($connectBDD, $difficulty, $km, $status, $time) {
    // Construire la requête SQL de base
    $query = "SELECT * FROM trails WHERE 1=1"; // 1=1 pour simplifier l'ajout de conditions
    $params = []; // Pour stocker les valeurs des paramètres

    // Ajouter des conditions pour la difficulté
    if ($difficulty) {
        $query .= " AND difficulty = :difficulty";
        $params[':difficulty'] = $difficulty;
    }

    // Ajouter des conditions pour la longueur (proximité de 0.5 km)
    if ($km) {
        $query .= " AND length_km BETWEEN :length_km_min AND :length_km_max";
        $params[':length_km_min'] = $km - 0.5; // 0.5 km moins
        $params[':length_km_max'] = $km + 0.5; // 0.5 km plus
    }

    // Ajouter des conditions pour le statut
    if ($status) {
        $query .= " AND status = :status";
        $params[':status'] = $status;
    }

    // Ajouter des conditions pour le temps (proximité de 0.5 heure)
    if ($time) {
        // Convertir le temps en heures décimales
        list($hours, $minutes) = explode(':', $time);
        $timeInHours = (int)$hours + ((int)$minutes / 60);

        $query .= " AND (CAST(SUBSTRING_INDEX(time, ':', 1) AS UNSIGNED) + 
                          (CAST(SUBSTRING_INDEX(time, ':', -1) AS UNSIGNED) / 60)) 
                          BETWEEN :time_min AND :time_max";
        $params[':time_min'] = $timeInHours - 0.5; // 0.5 heure moins
        $params[':time_max'] = $timeInHours + 0.5; // 0.5 heure plus
    }

    // Préparer et exécuter la requête
    $stmt = $connectBDD->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Renvoyer les résultats
}

//* Requêtes pour la map et les différentes données
// Fonction pour récupérer les bordures de la zone du parc
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
// Fonction pour récupérer uniquement les sentiers des maps
// il y a tous les sentiers dans un fichier data.php
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
// Fonction pour récupérer uniquement les point de vues des maps
// il y a tous les point de vues dans un fichier data.php
function get_mapLandmarks_data($connectBDD) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    header('Content-Type: application/json');

    // Récupérer tous les points d'intérêt + ID du sentier
    $sql = "SELECT lt.landmark_id, l.name, lt.trail_id, l.longitude, l.latitude, l.image 
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
                'name' => $poi['name'],
                'image' => $poi['image']
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
}