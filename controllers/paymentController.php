<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../models/ReservationModel.php';

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
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $reservationModel = new ReservationModel();
            $user_id = 1; 
            $reservation_id = $reservationModel->createReservation($user_id, $campsite_id, $start_date, $end_date, $price, "en attente"); // réservation par défaut "en attente"
            $_SESSION['reservation_id'] = $reservation_id;

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

    public function confirmReservation($reservation_id) {
        $reservationModel = new ReservationModel();
        return $reservationModel->updateReservationStatus($reservation_id, "confirmée");
    }
}