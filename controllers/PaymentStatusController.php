<?php

require_once 'Controller.php';

class PaymentStatusController extends Controller{
    public function paymentSuccess() {
    $message = "Votre paiement a été effectué avec succès.";
    $this->render('paymentSuccess', ['message' => $message]);
    }

    public function paymentFailed() {
    $message = "Votre paiement a échoué. Veuillez réessayer.";
    $this->render('paymentFailed', ['message' => $message]);
    }
}