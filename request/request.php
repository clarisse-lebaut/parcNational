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
// Fonction pour récupérer les sentiers avec la difficulté "Facile"
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


function get_data_status(){
    
}

function get_data_length(){
    
}

function get_data_time(){
    
}
?>
