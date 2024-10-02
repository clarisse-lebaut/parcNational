<?php
require_once __DIR__ . '/../controllers/PaymentController.php';
require_once __DIR__ . '/../models/CampsiteModel.php';

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

if ($promo_code === 'PROMO10') {// test code promo
    $price *= 0.9; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_payment'])) {
    // Création de la session Stripe avec le PaymentController
    $_SESSION['start_date'] = $start_date;
    $_SESSION['end_date'] = $end_date;
    $_SESSION['num_persons'] = $num_persons;
    $_SESSION['price'] = $price;

    $paymentController = new PaymentController();
    $paymentController->createCheckoutSession($campsite_id, $price, $start_date, $end_date, $num_persons);
} else {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Confirmation de Paiement</title>
        <script src="/assets/javascript/payment.js" defer></script>
    </head>
    <body>
        <h1>Récapitulatif de la commande</h1>

        <?php if ($campsite): ?>
            <p>Camping: <?= htmlspecialchars($campsite['name']); ?></p>
            <p>Date de début: <?= htmlspecialchars($start_date); ?></p>
            <p>Date de fin: <?= htmlspecialchars($end_date); ?></p>
            <p>Nombre de personnes: <?= htmlspecialchars($num_persons); ?></p>
            <p>Prix total : <span id="total_price"><?= htmlspecialchars($price); ?> €</span></p>

            <h2>Ajouter un code promo</h2>
        <form id="promo-form" method="POST">
            <label for="promo_code">Code promo :</label>
            <input type="text" id="promo_code" name="promo_code">
            <button type="button" id="apply-promo">Appliquer</button> <!-- Bouton "Appliquer" pour le code promo -->
            <input type="hidden" id="final_price" name="price" value="<?= htmlspecialchars($price); ?>">
        </form>

        <h2>Paiement</h2>
            <form id="payment-form" action="payment.php" method="POST">
                <input type="hidden" name="campsite_id" value="<?= $campsite_id; ?>">
                <input type="hidden" name="start_date" value="<?= htmlspecialchars($start_date); ?>">
                <input type="hidden" name="end_date" value="<?= htmlspecialchars($end_date); ?>">
                <input type="hidden" name="num_persons" value="<?= htmlspecialchars($num_persons); ?>">
                <input type="hidden" id="final_price_input" name="price" value="<?= htmlspecialchars($price); ?>"> <!-- Final price for submission -->
                <button type="submit" name="confirm_payment">Payer</button> <!-- Bouton "Payer" pour valider la commande -->
            </form>
        <?php else: ?>
            <p>Erreur : camping introuvable.</p>
        <?php endif; ?>
    </body>
    </html>
<?php
}