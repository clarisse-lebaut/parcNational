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

    public function createCheckoutSession($campsite_id, $price, $start_date, $end_date, $num_persons) {
        try {
            session_start();
            $_SESSION['start_date'] = $start_date;
            $_SESSION['end_date'] = $end_date;
            $_SESSION['num_persons'] = $num_persons;
            $_SESSION['price'] = $price;

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
                'success_url' => 'http://parcnational/views/reservationHistory.php?campsite_id=' . $campsite_id . '&status=success',
                'cancel_url' => 'http://parcnational/views/reservationHistory.php?campsite_id=' . $campsite_id . '&status=cancel',
            ]);

            header("Location: " . $checkout_session->url);
            exit();

        } catch (Exception $e) {
            error_log("Erreur lors de la création de la session Stripe: " . $e->getMessage());
            echo "Une erreur s'est produite lors du paiement.";
        }
    }
}