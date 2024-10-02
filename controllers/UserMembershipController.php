<?php

require_once __DIR__ . '/../vendor/autoload.php';
use Stripe\Stripe;
use Stripe\Checkout\Session;

require_once ('Controller.php');
require_once __DIR__ . '/../model/Membership.php';

class UserMembershipController extends Controller{
    public function __construct() {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
    }

    public function addMember(){
        $this->render('addMembership');
    }

    public function subscribe3Months(){
        if(isset($_SESSION['user_id'])){
            $membership = new Membership('membership');
            $activeMembership = $membership->getActiveMembership($_SESSION['user_id']);
            if ($activeMembership) {
                // Information about already existing abo
                $this->render('addMembership', ['message' => 'Vous avez déjà un abonnement actif.']); 
            }else{
                $today = new DateTime();
                $endDate = new DateTime();
                $endDate->modify('+3 months');

                $membership->saveNewMembership($today->format('Y-m-d'), $endDate->format('Y-m-d'), $_SESSION['user_id']);
                $this->createCheckoutSession(3, 30);
            }
            
        }else{
            $this->redirect('login');
        }
    }

    public function subscribe6Months(){
        if(isset($_SESSION['user_id'])){
            $membership = new Membership('membership');
            $activeMembership = $membership->getActiveMembership($_SESSION['user_id']);
            if($activeMembership){
                $this->render('addMembership', ['message' => 'Vous avez déjà un abonnement actif.']);
            }else{
                $today = new DateTime();
                $endDate = new DateTime();
                $endDate->modify('+6 months');
                $membership->saveNewMembership($today->format('Y-m-d'), $endDate->format('Y-m-d'), $_SESSION['user_id']);
                $this->createCheckoutSession(6, 50);
            }
            
        }else{
            $this->redirect('login');
        }
    }

    public function subscribe12Months(){
        if(isset($_SESSION['user_id'])){
            $membership = new Membership('membership');
            $activeMembership = $membership->getActiveMembership($_SESSION['user_id']);
            if($activeMembership){
                $this->render('addMembership', ['message' => 'Vous avez déjà un abonnement actif.']);
            }else{
            $today = new DateTime();
            $endDate = new DateTime();
            $endDate->modify('+12 months');
            $membership->saveNewMembership($today->format('Y-m-d'), $endDate->format('Y-m-d'), $_SESSION['user_id']);
            $this->createCheckoutSession(12, 90);
        }
        }else{
            $this->redirect('login');
        }
    }

    public function createCheckoutSession($membershipMonths, $price) {
        try {
            // Créer une session Stripe Checkout
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Membership ' . $membershipMonths . ' months',
                        ],
                        'unit_amount' => $price * 100, // Prix en centimes
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'http://localhost/parcNational/payment-success',
                'cancel_url' => 'http://localhost/parcNational/payment-failed',
            ]);

            header("Location: " . $checkout_session->url);
            exit();

        } catch (Exception $e) {
            error_log("Erreur lors de la création de la session Stripe: " . $e->getMessage());
            echo "Une erreur s'est produite lors du paiement.";
        }
    }
    public function viewMembership() {
        if (isset($_SESSION['user_id'])) {
            $membership = new Membership('membership');
            $currentMembership = $membership->getMembershipByUserId($_SESSION['user_id']);
            
            if ($currentMembership) {
                $this->render('userMembership', ['membership' => $currentMembership]);
            } else {
                $this->render('userMembership', ['message' => 'Vous n\'avez pas encore d\'adhésion active.']);
            }
        } else {
            $this->redirect('login');
        }
    }
}