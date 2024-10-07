<?php
require_once __DIR__ . '/../config/connectBDD.php';

class ManageTrails {
    public function count_trails($bdd) {
        $stmt = $bdd->prepare("SELECT COUNT(*) as total FROM trails");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function get_trails($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM trails");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get_trails_by_id($bdd, $trail_id) {
        $stmt = $bdd->prepare("SELECT * FROM trails WHERE trail_id = :trail_id");
        $stmt->bindParam(':trail_id', $trail_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Récupérer une seule ligne
    }
    public function name_trails($bdd) {
        $stmt = $bdd->prepare("SELECT name FROM trails LIMIT 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['name'];  // Retourne uniquement le nom
    }
    public function set_trails($bdd) {
        $stmt = $bdd->prepare("SELECT * FROM trails");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Méthode pour supprimer un utilisateur spécifique par son ID
    public function delete($bdd, $trail_id){
        $sql = "DELETE FROM trails WHERE trail_id = :trail_id";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':trail_id', $trail_id, PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        } else {
            return false; 
        }
    }

public function create_trails($bdd, $name, $description, $distance, $difficulty, $status, $image, $longitude, $latitude) {
    $sql = "INSERT INTO trails (name, description, distance, difficulty, status, image, longitude, latitude)
            VALUES (:name, :description, :distance, :difficulty, :status, :image, :longitude, :latitude)";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':distance', $distance);
    $stmt->bindParam(':difficulty', $difficulty);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':longitude', $longitude);
    $stmt->bindParam(':latitude', $latitude);
    return $stmt->execute();
}

public function update_trails($bdd, $trail_id, $name, $description, $distance, $difficulty, $status, $image, $longitude, $latitude) {
    // Préparation de la requête SQL avec les champs longitude et latitude
    $sql = "UPDATE trails SET 
                name = :name, 
                description = :description, 
                distance = :distance, 
                difficulty = :difficulty, 
                status = :status, 
                image = :image, 
                longitude = :longitude, 
                latitude = :latitude
            WHERE trail_id = :trail_id";
    
    // Préparation de la requête
    $stmt = $bdd->prepare($sql);
    
    // Association des paramètres à la requête
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':distance', $distance);
    $stmt->bindParam(':difficulty', $difficulty);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':longitude', $longitude); // Correct binding for longitude
    $stmt->bindParam(':latitude', $latitude);   // Correct binding for latitude
    $stmt->bindParam(':trail_id', $trail_id);   // Binding the trail ID

    // Exécution de la requête
    return $stmt->execute();
}

// Fonction pour récupérer uniquement les sentiers des maps
// il y a tous les sentiers dans un fichier data.php
public function get_mapTrails_data($bdd) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    header('Content-Type: application/json');

    // Requête SQL pour récupérer tous les sentiers
    $sql = "SELECT t.trail_id, t.name, pg.part_number, pg.coordinate_number, pg.longitude, pg.latitude
            FROM trails t
            JOIN position_geographic pg ON t.trail_id = pg.trail_id
            ORDER BY t.trail_id, pg.part_number, pg.coordinate_number";

    $stmt = $bdd->prepare($sql);
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


}
?>