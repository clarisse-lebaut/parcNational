<?php

include_once '../class/connectBDD.php';

function get_news($connectBDD){
    $sql = "SELECT * FROM news";
    $stmt = $connectBDD->prepare($sql);
    $stmt->execute();
    return $stmt->FetchAll(PDO::FETCH_ASSOC);
}