<?php
function get_trails_all($connectBDD): array {
    $requeteSQL = "SELECT * from trails";
    $getAllData = $connectBDD->prepare($requeteSQL);
    $getAllData->execute();
    $trails = $getAllData->fetchAll(PDO::FETCH_ASSOC);
    return $trails;
}

//* Requête pour le filtre des sentiers

function get_data_difficulty($connectBDD) {
    $difficulties = ["Facile", "Moyen", "Difficile"];
    
    // Création dynamique des placeholders
    $placeholders = implode(',', array_fill(0, count($difficulties), '?'));

    // Requête SQL
    $sql = "SELECT * FROM trails WHERE difficulty IN ($placeholders)";
    $stmt = $connectBDD->prepare($sql);
    $stmt->execute($difficulties);
    
    // Renvoi des résultats sous forme de tableau
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




function get_data_status(){
    
}

function get_data_length(){
    
}

function get_data_time(){
    
}
?>
