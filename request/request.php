<?php
// Instancier la classe ConnectBDD et obtenir la connexion PDO
$connectBDDInstance = new ConnectBDD();
$connectBDD = $connectBDDInstance->connectBDD();

function get_trails_all($connectBDD) {
    $requeteSQL = "SELECT * from trails";
    $getAllData = $connectBDD->prepare($requeteSQL);
    $getAllData->execute();
    $trails = $getAllData->fetchAll(PDO::FETCH_ASSOC);
    return $trails;
}

//* Requêtes pour le filtre des sentiers
// Fonction pour récupérer les sentiers avec la difficulté
function get_data_difficulty($connectBDD, $difficulty) {
    // Requête SQL pour récupérer uniquement les sentiers avec la difficulté spécifiée
    $sql = "SELECT * FROM trails WHERE difficulty = ?";
    $stmt = $connectBDD->prepare($sql);

    try {
        $stmt->execute([$difficulty]);

        // Récupérer les résultats
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Si aucune donnée n'est trouvée, renvoie un message d'erreur au format JSON
        if (empty($results)) {
            return json_encode(['error' => 'Aucun sentier trouvé.']);
        }
        
        // Retourne les résultats en format JSON
        return json_encode($results);

    } catch (Exception $e) {
        // Renvoie une erreur en format JSON
        return json_encode(['error' => 'Une erreur est survenue : ' . $e->getMessage()]);
    }
}

function get_data_status($connectBDD, $status){
    // Requête SQL pour récupérer uniquement les sentiers selon le satut
    $sql = "SELECT * FROM trails WHERE status = ?";
    $stmt = $connectBDD->prepare($sql);

    try {
        $stmt->execute([$status]);

        // Récupérer les résultats
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Si aucune donnée n'est trouvée, renvoie un message d'erreur au format JSON
        if (empty($results)) {
            return json_encode(['error' => 'Aucun sentier trouvé.']);
        }
        
        // Retourne les résultats en format JSON
        return json_encode($results);

    } catch (Exception $e) {
        // Renvoie une erreur en format JSON
        return json_encode(['error' => 'Une erreur est survenue : ' . $e->getMessage()]);
    }
    
}

function get_data_length($connectBDD, $km){
    // Définir une tolérance (par exemple, 0,5 km)
    $epsilon = 0.5;

    // Requête SQL pour récupérer les sentiers dont la longueur est proche du km donné
    $sql = "SELECT * FROM trails WHERE length_km BETWEEN ? AND ?";
    $stmt = $connectBDD->prepare($sql);

    try {
        // Calculer la plage de valeurs acceptables autour du km donné
        $minKm = $km - $epsilon;
        $maxKm = $km + $epsilon;

        // Exécuter la requête avec les valeurs minimum et maximum
        $stmt->execute([$minKm, $maxKm]);

        // Récupérer les résultats
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Si aucune donnée n'est trouvée, renvoie un message d'erreur au format JSON
        if (empty($results)) {
            return json_encode(['error' => 'Aucun sentier trouvé.']);
        }

        // Retourne les résultats en format JSON
        return json_encode($results);
    } catch (\Throwable $th) {
        // Renvoie une erreur en format JSON
        return json_encode(['error' => 'Une erreur est survenue : ' . $th->getMessage()]);
    }
}


function get_data_time($connectBDD, $time){
    // Convertir l'heure fournie en datetime pour manipuler plus facilement
    $time = new DateTime($time);

    // Définir une tolérance de 30 minutes avant et après l'heure donnée
    $minTime = clone $time;
    $minTime->modify('-30 minutes');
    $maxTime = clone $time;
    $maxTime->modify('+30 minutes');

    // Requête SQL pour récupérer les sentiers dont l'heure est comprise dans l'intervalle
    $sql = "SELECT * FROM trails WHERE time BETWEEN ? AND ?";
    $stmt = $connectBDD->prepare($sql);

    try {
        // Exécuter la requête avec les valeurs minimum et maximum
        $stmt->execute([$minTime->format('H:i:s'), $maxTime->format('H:i:s')]);

        // Récupérer les résultats
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Si aucune donnée n'est trouvée, renvoie un message d'erreur au format JSON
        if (empty($results)) {
            return json_encode(['error' => 'Aucun sentier trouvé dans cette plage horaire.']);
        }

        // Retourne les résultats en format JSON
        return json_encode($results);
    } catch (\Throwable $th) {
        // Renvoie une erreur en format JSON
        return json_encode(['error' => 'Une erreur est survenue : ' . $th->getMessage()]);
    } 
}

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
