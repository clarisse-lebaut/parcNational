<?php
require 'vendor/autoload.php';
require_once __DIR__ . '/../config/connectBDD.php';

\Stripe\Stripe::setApiKey('sk_test_51Q49ysE0rTiVkRV3XcXRXsR5xzk7zRx5xEK1l13ssOlLyUWyizU82QprOKh8einZGRAG0BXeTJZfP9UkGZLI6z2v00GO8Ymzke');

$campsite_id = isset($_POST['campsite_id']) ? intval($_POST['campsite_id']) : 0;
$price = isset($_POST['price']) ? floatval($_POST['price']) : 0;

if ($campsite_id > 0 && $price > 0) {
    // créer une session stripe checkout
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => 'Réservation Camping #' . $campsite_id,
                ],
                'unit_amount' => $price * 100, // centimes
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'http://localhost/parcNational/views/calendar.php?campsite_id=' . $campsite_id . '&status=success',
        'cancel_url' => 'http://localhost/parcNational/views/calendar.php?campsite_id=' . $campsite_id . '&status=cancel',
    ]);

    header("Location: " . $checkout_session->url);
    exit;
} else {
    echo "Erreur : ID du camping ou prix invalide.";
}
