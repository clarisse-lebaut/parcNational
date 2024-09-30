<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController {

    public function __construct() {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
    }

    public function createCheckoutSession($campsite_id, $price) {
        try {
            // Créer une session Stripe Checkout
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Réservation Camping #' . $campsite_id,
                        ],
                        'unit_amount' => $price * 100, // Prix en centimes
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'http://localhost/parcNational/views/reservationHistory.php',
                'cancel_url' => 'http://localhost/parcNational/views/reservationHistory.php',
            ]);

            header("Location: " . $checkout_session->url);
            exit();

        } catch (Exception $e) {
            error_log("Erreur lors de la création de la session Stripe: " . $e->getMessage());
            echo "Une erreur s'est produite lors du paiement.";
        }
    }
}