<?php
function getAllTrails($connectBDD): array {
    $requeteSQL = "SELECT * from trails";
    $getAllData = $connectBDD->prepare($requeteSQL);
    $getAllData->execute();
    $trails = $getAllData->fetchAll(PDO::FETCH_ASSOC);
    return $trails;
}
?>
