<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/connectBDD.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
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
    exit();
} else {
    if ($paymentSuccess) {
        header("Location: /parcNational/views/calendar.php?campsite_id=$campsite_id&status=success");
        exit();
    } else {
        header("Location: /parcNational/views/calendar.php?campsite_id=$campsite_id&status=cancel");
        exit();
    }
}