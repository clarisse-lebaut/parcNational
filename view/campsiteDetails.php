<?php
include_once '../model/ConnectBDD.php';

// Créer une instance de connexion
$connect = new ConnectBDD();
$bdd = $connect->connectBDD(); // Connexion à la base de données

// Vérifie que la connexion est réussie
if ($bdd) {
    // Récupérer l'ID du camping depuis l'URL
    $campsite_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($campsite_id > 0) {
        // Requête SQL pour récupérer les détails du camping
        $sql = "SELECT * FROM campsite WHERE campsite_id = :id";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':id', $campsite_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $camping = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<h1>" . $camping['name'] . "</h1>";
            echo "<img src='/" . $camping['image'] . "' alt='" . $camping['name'] . "'>";
            echo "<p>" . $camping['description'] . "</p>";
            echo "<p>Adresse : " . $camping['address'] . ", " . $camping['city'] . " " . $camping['zipcode'] . "</p>";
            echo "<p>Status : " . $camping['status'] . "</p>";
        } else {
            echo "Camping introuvable.";
        }
    } else {
        echo "ID de camping non valide.";
    }
} else {
    echo "Erreur de connexion à la base de données.";
}
?>
