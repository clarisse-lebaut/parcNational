<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../models/ReservationModel.php'; 
require_once __DIR__ . '/../models/CampsiteModel.php'; 

use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController {

    public function __construct() {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
    }

    public function processPayment() {
        $campsite_id = isset($_POST['campsite_id']) ? intval($_POST['campsite_id']) : 0;
        $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
        $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
        $num_persons = isset($_POST['num_persons']) ? intval($_POST['num_persons']) : 0;
        $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
        $promo_code = isset($_POST['promo_code']) ? $_POST['promo_code'] : '';

        $campsiteModel = new CampsiteModel();
        $campsite = $campsiteModel->getCampsiteById($campsite_id);

        // Vérifier s'il y a un code promo et ajuster le prix
        if ($promo_code === 'PROMO10') {
            $price *= 0.9;
        }

        // si 'payer' est soumis
        if (isset($_POST['confirm_payment'])) {
            $this->createCheckoutSession($campsite_id, $price, $start_date, $end_date, $num_persons);
        } else {
            require __DIR__ . '/../views/payment.php';
        }
    }

    public function createCheckoutSession($campsite_id, $price, $start_date, $end_date, $num_persons) {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $reservationModel = new ReservationModel();
            $user_id = $_SESSION['user_id'];
            $reservation_id = $reservationModel->createReservation($user_id, $campsite_id, $start_date, $end_date, $price, "en attente");
            $_SESSION['reservation_id'] = $reservation_id;
    
            $checkout_session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Réservation Camping #' . $campsite_id,
                        ],
                        'unit_amount' => $price * 100,  // Prix en centimes
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'http://reservation_history?campsite_id=' . $campsite_id . '&status=success', // URL redirigée via le routeur
                'cancel_url' => 'http://reservation_history?campsite_id=' . $campsite_id . '&status=cancel',
            ]);
    
            header("Location: " . $checkout_session->url);
            exit();
    
        } catch (Exception $e) {
            error_log("Erreur lors de la création de la session Stripe: " . $e->getMessage());
            echo "Une erreur s'est produite lors du paiement.";
        }
    }
    
    // reservation confirmée quand paiment reussi
    public function confirmReservation($reservation_id) {
        $reservationModel = new ReservationModel();
        return $reservationModel->updateReservationStatus($reservation_id, "confirmée");
    }
}
