<?php
require_once __DIR__ . '/../controllers/PaymentController.php';

// Récupérer les informations de réservation depuis le formulaire
$campsite_id = isset($_POST['campsite_id']) ? intval($_POST['campsite_id']) : 0;
$price = isset($_POST['price']) ? floatval($_POST['price']) : 0;

if ($campsite_id > 0 && $price > 0) {
    $paymentController = new PaymentController();

    // Appelle méthode qui créer session de paiement stripe
    $paymentController->createCheckoutSession($campsite_id, $price);
} else {
    echo "Erreur : les informations de réservation sont invalides.";
}
