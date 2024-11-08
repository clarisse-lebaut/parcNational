<?php
require_once __DIR__ . '/../models/CampsiteModel.php';
require_once __DIR__ . '/../controllers/ReservationController.php';
require_once __DIR__ . '/../controllers/PaymentController.php';
require_once __DIR__ . '/../controllers/CampsiteController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$campsite_id = isset($_GET['campsite_id']) ? intval($_GET['campsite_id']) : 0;

if ($campsite_id > 0) {
    $campsiteModel = new CampsiteModel();
    $campsiteController = new CampsiteController($campsiteModel);
    $campsite = $campsiteModel->getCampsiteById($campsite_id);
    $vacationEvents = $campsiteController->getVacationEvents($campsite_id);
} else {
    $campsite = null;
    $vacationEvents = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_id !== null) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $num_persons = $_POST['num_persons'];
    $price = $_POST['price'];

    // appel paymentController; gérer la session stripe
    $paymentController = new PaymentController();
    $paymentController->createCheckoutSession($campsite_id, $price, $start_date, $end_date, $num_persons, $user_id);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation - <?= $campsite ? htmlspecialchars($campsite['name']) : 'Camping'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.15/index.global.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.15/timegrid.min.css" />
    <link rel="stylesheet" href="assets/style/_global.css">
    <link rel="stylesheet" href="assets/style/calendar.css">
</head>

<body>
    <header>
        <?php include __DIR__ . '/../components/_header.php'; ?>
    </header>
    <main>
    <section>
        <?php if ($campsite): ?>
            <div class="title-and-image ">
                <h1 class="campsite-title"><?= htmlspecialchars($campsite['name']); ?></h1>
                <div class="calendar-info" data-price-per-night="<?= htmlspecialchars($campsite['price_per_night']); ?>">
                <img src="<?= htmlspecialchars($campsite['image']); ?>" alt="Image de <?= htmlspecialchars($campsite['name']); ?>" class="calendar-img">
                </div>
            </div>
        <?php else: ?>
            <p class="error">Erreur : Camping introuvable.</p>
        <?php endif; ?>
    </section>

  <h2 class="reservation-title">Réserver ce camping</h2>

<div class="calendar-and-form-container">
    <!-- CALENDRIER-->
    <section class="reservation-section calendar-item">
        <p class="instruction-message">Veuillez sélectionner vos dates de séjour en les glissant sur le calendrier ci-dessous.</p>
        <div id="calendar"> </div>
    </section>

    <!-- FORMULAIRE -->
    <div class="calendar-form-container">
        <section class="reservation-section">
            <form action="/parcNational/payment" method="POST">
                <div class="date-fields">
                    <input type="hidden" name="campsite_id" value="<?= $campsite_id; ?>">
                    <div class="date-field">
                        <label for="start_date">Du</label>
                        <input type="text" id="start_date" name="start_date" readonly required>
                        <label for="end_date">Au</label>
                        <input type="text" id="end_date" name="end_date" readonly required>
                    </div>
                </div>
                <div class="persons-field">
                    <label for="num_persons">Nombre de personnes </label>
                    <input type="number" id="num_persons" name="num_persons" min="1" max="10" required>
                </div>
                <input type="hidden" name="price" id="calculated_price" value="0">
                <div id="calendar-price-resa">
                    <p>Prix total: <span id="total-price">0</span> €</p>
                </div>
                <input type="submit" class="calendar-resa-button" value="RÉSERVER">
            </form>
        </section>
    </div>
</div>
</main>
    <footer>
        <?php include __DIR__ . '/../components/_footer.php'; ?>
    </footer>

    <script> let vacationEvents = <?= json_encode($vacationEvents); ?>; </script>
    <!-- SCRIPTS -->
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.15/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.15/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rrule/2.6.8/rrule.min.js"></script>
    <script src="assets/script/calendar.js"></script>
</body>
</html>
