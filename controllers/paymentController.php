<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../models/ReservationModel.php';
require_once __DIR__ . '/../models/CampsiteModel.php';
require_once __DIR__ . '/ReservationController.php';

use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController {

    public function __construct() {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
    }

    public function showPaymentForm() {
        $campsite_id = isset($_GET['campsite_id']) ? intval($_GET['campsite_id']) : 0;
        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
        $num_persons = isset($_GET['num_persons']) ? intval($_GET['num_persons']) : 0;
        $price = isset($_GET['price']) ? floatval($_GET['price']) : 0;

        $campsiteModel = new CampsiteModel();
        $campsite = $campsiteModel->getCampsiteById($campsite_id);

        if (!$campsite) {
            die("Erreur : camping introuvable.");
        }
        require __DIR__ . '/../views/payment.php';
    }

    public function processPayment() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        $campsite_id = isset($_POST['campsite_id']) ? intval($_POST['campsite_id']) : 0;
        $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
        $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
        $num_persons = isset($_POST['num_persons']) ? intval($_POST['num_persons']) : 0;
        $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
        $promo_code = isset($_POST['promo_code']) ? $_POST['promo_code'] : '';
        $campsiteModel = new CampsiteModel();
        $campsite = $campsiteModel->getCampsiteById($campsite_id);
        if (!$campsite) {
            die("Erreur : camping introuvable.");
        }
    
        if ($promo_code === 'PROMO10') {
            $price *= 0.9;
        }
    
        if (!isset($_SESSION['user_id'])) {
            die("Erreur : utilisateur non connecté.");
        }
        $user_id = $_SESSION['user_id'];
    
        $reservationController = new ReservationController();
        $reservation_id = $reservationController->createReservation($user_id, $campsite_id, $start_date, $end_date, $price, "en attente");
    
        if ($reservation_id) {
            $_SESSION['reservation_id'] = $reservation_id;
    
            // Démarrer stripe
            if (isset($_POST['confirm_payment'])) {
                $this->createCheckoutSession($campsite_id, $price, $start_date, $end_date, $num_persons, $promo_code);
            } else {
                require __DIR__ . '/../views/payment.php';
            }
        } else {
            echo "Erreur lors de la création de la réservation. Veuillez réessayer.";
        }
    }
    public function applyPromoCode() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $promo_code = isset($_POST['promo_code']) ? $_POST['promo_code'] : '';
            $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
    
            $response = ['success' => false];
    
            // Vérifiez le code promo
            if ($promo_code === 'PROMO10') {
                $new_price = $price * 0.9;
                $response = [
                    'success' => true,
                    'new_price' => number_format($new_price, 2) // Format pour 2 décimales
                ];
            }
    
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
    }
        
        
    public function createCheckoutSession($campsite_id, $price, $start_date, $end_date, $num_persons, $promo_code = null) {
        try {
            // récupérer les id des coupons stripe
            $discounts = [];
            if ($promo_code === 'PROMO10') {  
                $discounts[] = ['coupon' => 'qMeqFk1H']; 
            }

            $checkout_session = Session::create([
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
                'discounts' => $discounts,
                'success_url' => 'http://localhost/parcNational/reservation_history?campsite_id=' . $campsite_id . '&status=success',
                'cancel_url' => 'http://localhost/parcNational/reservation_history?campsite_id=' . $campsite_id . '&status=cancel',
            ]);
            header("Location: " . $checkout_session->url);
            exit();
        } catch (Exception $e) {
            error_log("Erreur lors de la création de la session Stripe: " . $e->getMessage());
            echo "Une erreur s'est produite lors du paiement.";
        }
    }
}
