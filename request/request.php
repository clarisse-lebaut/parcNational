<!-- 
//! quand tu vas tout réunir, il te suffit simplement de récupérer tout de la table
//? une fois que tu as tout récupérer il faut que tu ajoute les paramètre avec le WHERE

-->

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

function get_trails_landmarks($connectBDD){
    $sql = "SELECT * FROM landmarks_trails";
    $stmt = $connectBDD->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
