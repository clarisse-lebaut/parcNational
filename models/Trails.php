<?php 
require_once 'Model.php';

class Trails extends Model {

    public function __construct($table){
        parent::__construct($table);
    }    

    //* Requêtes pour obtenir tous les sentiers
    public function get_all_trails() {
        $sql = "SELECT * FROM trails";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //* Fonction générique pour exécuter des requêtes
    public function executeQuery($sql, $params = [], $fetchAll = false) {
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        return $fetchAll ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //* Requêtes pour les détails d'un seul sentier
    public function get_trail_id($id): array {
        $sql = "SELECT * FROM trails WHERE trail_id = :id";
        return $this->executeQuery($sql, [':id' => $id]);
    }

    public function get_trails_time($time) {
        $sql = "SELECT * FROM trails WHERE time = :time";
        return $this->executeQuery($sql, [':time' => $time]);
    }

    public function get_trails_km($km) {
        $sql = "SELECT * FROM trails WHERE length_km = :length_km";
        return $this->executeQuery($sql, [':length_km' => $km]);
    }

    public function get_trails_difficulty($difficulty): array {
        $sql = "SELECT * FROM trails WHERE difficulty = :difficulty";
        return $this->executeQuery($sql, [':difficulty' => $difficulty], true);
    }

    public function get_trails_status($state) {
        $sql = "SELECT * FROM trails WHERE status = :status";
        return $this->executeQuery($sql, [':status' => $state]);
    }

    public function get_trails_description($description) {
        $sql = "SELECT * FROM trails WHERE description = :description";
        return $this->executeQuery($sql, [':description' => $description]);
    }
    public function get_trails_infos($infos) {
        $sql = "SELECT * FROM trails WHERE infos = :infos";
        return $this->executeQuery($sql, [':infos' => $infos]);
    }
    public function get_trails_acces($acces) {
        $sql = "SELECT * FROM trails WHERE acces = :acces";
        return $this->executeQuery($sql, [':acces' => $acces]);
    }

    public function get_trails_landmarks($trail_id) {
        $sql = "SELECT lt.landmark_id, l.name, l.description, l.location 
                FROM landmarks_trails lt
                JOIN landmarks l ON lt.landmark_id = l.landmark_id
                WHERE lt.trail_id = :trail_id";    
        return $this->executeQuery($sql, [':trail_id' => $trail_id], true);
    }

    //* Requêtes pour le filtre des sentiers
    public function get_filtered_trails($difficulty = null, $km = null, $status = null, $time = null) {
        $query = "SELECT * FROM trails WHERE 1=1"; // 1=1 pour simplifier l'ajout de conditions
        $params = []; // Stocker les valeurs des paramètres

        if ($difficulty) {
            $query .= " AND difficulty = :difficulty";
            $params[':difficulty'] = $difficulty;
        }

        if ($km) {
            $query .= " AND length_km BETWEEN :length_km_min AND :length_km_max";
            $params[':length_km_min'] = $km - 0.5;
            $params[':length_km_max'] = $km + 0.5;
        }

        if ($status) {
            $query .= " AND status = :status";
            $params[':status'] = $status;
        }

        if ($time) {
            list($hours, $minutes) = explode(':', $time);
            $timeInHours = (int)$hours + ((int)$minutes / 60);

            $query .= " AND (CAST(SUBSTRING_INDEX(time, ':', 1) AS UNSIGNED) + 
                              (CAST(SUBSTRING_INDEX(time, ':', -1) AS UNSIGNED) / 60)) 
                              BETWEEN :time_min AND :time_max";
            $params[':time_min'] = $timeInHours - 0.5;
            $params[':time_max'] = $timeInHours + 0.5;
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //* Requêtes pour la carte
    public function get_map_data() {
        $sql = "SELECT part_number, coordinate_number, mystery_number, longitude, latitude
                FROM map
                ORDER BY part_number, coordinate_number, mystery_number";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $multipolygons = [];
        $currentPolygon = [];
        $currentPart = [];
        $currentPartNumber = null;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $partNumber = $row['part_number'];

            if ($currentPartNumber !== null && $currentPartNumber !== $partNumber) {
                if (!empty($currentPart) && $currentPart[0] !== end($currentPart)) {
                    $currentPart[] = $currentPart[0];
                }
                $currentPolygon[] = $currentPart;
                $currentPart = [];
            }

            $currentPart[] = [(float)$row['longitude'], (float)$row['latitude']];
            $currentPartNumber = $partNumber;
        }

        if (!empty($currentPart)) {
            if ($currentPart[0] !== end($currentPart)) {
                $currentPart[] = $currentPart[0];
            }
            $currentPolygon[] = $currentPart;
        }

        if (!empty($currentPolygon)) {
            $multipolygons[] = $currentPolygon;
        }

        return [
            'type' => 'FeatureCollection',
            'features' => [
                [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'MultiPolygon',
                        'coordinates' => $multipolygons
                    ]
                ]
            ]
        ];
    }

    public function get_map_trails_data() {
        $sql = "SELECT t.trail_id, t.name, pg.part_number, pg.coordinate_number, pg.longitude, pg.latitude
                FROM trails t
                JOIN position_geographic pg ON t.trail_id = pg.trail_id
                ORDER BY t.trail_id, pg.part_number, pg.coordinate_number";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $trails = [];
        $currentTrailId = null;
        $currentLineString = [];
        $currentPartNumber = null;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $trailId = $row['trail_id'];
            $partNumber = $row['part_number'];

            if ($currentTrailId !== null && $currentTrailId !== $trailId) {
                if (!empty($currentLineString)) {
                    $trails[$currentTrailId]['linestrings'][] = $currentLineString;
                }
                $currentLineString = [];
            }

            if ($currentPartNumber !== null && $currentPartNumber !== $partNumber) {
                if (!empty($currentLineString)) {
                    $trails[$trailId]['linestrings'][] = $currentLineString;
                }
                $currentLineString = [];
            }

            $currentLineString[] = [(float)$row['longitude'], (float)$row['latitude']];
            $currentPartNumber = $partNumber;
            $currentTrailId = $trailId;

            if (!isset($trails[$trailId])) {
                $trails[$trailId] = [
                    'trail_id' => $trailId,
                    'name' => $row['name'],
                    'linestrings' => []
                ];
            }
        }

        if (!empty($currentLineString)) {
            $trails[$currentTrailId]['linestrings'][] = $currentLineString;
        }

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => []
        ];

        foreach ($trails as $trail) {
            $geojson['features'][] = [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'MultiLineString',
                    'coordinates' => $trail['linestrings']
                ],
                'properties' => [
                    'trail_id' => $trail['trail_id'],
                    'name' => $trail['name']
                ]
            ];
        }

        return $geojson;
    }
}
