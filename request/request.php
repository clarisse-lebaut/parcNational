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

    // Ajouter des conditions pour la longueur
    if ($km) {
        $query .= " AND length = :length";
        $params[':length'] = $km;
    }

    // Ajouter des conditions pour le statut
    if ($status) {
        $query .= " AND status = :status";
        $params[':status'] = $status;
    }

    // Ajouter des conditions pour le temps
    if ($time) {
        $query .= " AND time = :time";
        $params[':time'] = $time;
    }

    // Préparer et exécuter la requête
    $stmt = $connectBDD->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Renvoyer les résultats
}
?>
