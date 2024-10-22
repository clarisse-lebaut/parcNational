<?php
require_once __DIR__ . '/../controllers/PaymentController.php';
require_once __DIR__ . '/../models/CampsiteModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérification du code promo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['promo_code'])) {
    $promo_code = $_POST['promo_code'];
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;

    $response = ['success' => false];

    if ($promo_code === 'PROMO10') {
        $new_price = $price * 0.9; 
        $response['success'] = true;
        $response['new_price'] = $new_price;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Si on arrive ici, c'est pour afficher la page de paiement classique
$campsite_id = isset($_POST['campsite_id']) ? intval($_POST['campsite_id']) : 0;
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$num_persons = isset($_POST['num_persons']) ? intval($_POST['num_persons']) : 0;
$price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
$promo_code = isset($_POST['promo_code']) ? $_POST['promo_code'] : '';

$campsiteModel = new CampsiteModel();
$campsite = $campsiteModel->getCampsiteById($campsite_id);

if ($promo_code === 'PROMO10') {
    $price *= 0.9; 
}

// Gestion du paiement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_payment'])) {
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
        <link rel="stylesheet" href="../assets/styles/_global.css">
        <link rel="stylesheet" href="../assets/styles/payment.css">
        <script src="/assets/javascript/payment.js" defer></script>
    </head>
    <body>
        <header>
            <?php include __DIR__ . '/../components/_header.php'; ?>
        </header>
        <main>
    <h1 class="payment-title">Récapitulatif de la commande</h1>

    <?php if ($campsite): ?>
        <div class="payment-container"> 
            <div class="payment-card">
                <h2>Informations sur la réservation</h2>
                <b><?= htmlspecialchars($campsite['name']); ?></b>
                <p>Du <b><?= htmlspecialchars($start_date); ?></b> au <b> <?= htmlspecialchars($end_date); ?> </b> </p>
                <p> <b> <?= htmlspecialchars($num_persons); ?></b> personnes </p>
                <p>Prix total : <span id="payment-total_price"><?= htmlspecialchars($price); ?> €</span></p>
            </div>

            <div class="payment-card">
                <h2>Ajouter un code promo</h2>
                <form id="promo-form" method="POST">
                    <label for="promo_code">Code promo :</label>
                    <input type="text" id="promo_code" name="promo_code">
                    <button type="button" id="apply-promo">Appliquer</button>
                    <input type="hidden" id="final_price" name="price" value="<?= htmlspecialchars($price); ?>">
                    <p id="promo_error" style="color: red;"></p>
                </form>
            </div>

        <form id="payment-form" action="payment.php" method="POST">
            <input type="hidden" name="campsite_id" value="<?= $campsite_id; ?>">
            <input type="hidden" name="start_date" value="<?= htmlspecialchars($start_date); ?>">
            <input type="hidden" name="end_date" value="<?= htmlspecialchars($end_date); ?>">
            <input type="hidden" name="num_persons" value="<?= htmlspecialchars($num_persons); ?>">
            <input type="hidden" id="final_price_input" name="price" value="<?= htmlspecialchars($price); ?>"> 
            <button type="submit" name="confirm_payment">Payer</button>
        </form>
    <?php else: ?>
        <p>Erreur : camping introuvable.</p>
    <?php endif; ?>
</main>
        <footer>
            <?php include __DIR__ . '/../components/_footer.php'; ?>
        </footer>
    </body>
    </html>

<?php
}
?>
