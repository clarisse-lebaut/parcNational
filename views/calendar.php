<?php
require_once __DIR__ . '/../models/CampsiteModel.php';
require_once __DIR__ . '/../controllers/ReservationController.php';

$campsite_id = isset($_GET['campsite_id']) ? intval($_GET['campsite_id']) : 0;
$status = isset($_GET['status']) ? $_GET['status'] : ''; // Récupérer le statut du paiement
$message = '';

if ($status === 'success') {
    $message = "Paiement réussi ! Votre réservation a été confirmée.";
} elseif ($status === 'cancel') {
    $message = "Le paiement a été annulé. Vous pouvez réessayer.";
}

if ($campsite_id > 0) {
    $campsiteModel = new CampsiteModel();
    $campsite = $campsiteModel->getCampsiteById($campsite_id);
} else {
    $campsite = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $num_persons = $_POST['num_persons'];
    $price = $_POST['price'];
    $user_id = 1;

    header("Location: payment.php?campsite_id=$campsite_id&start_date=$start_date&end_date=$end_date&num_persons=$num_persons&price=$price");    exit;}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation - <?= $campsite ? htmlspecialchars($campsite['name']) : 'Camping'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.15/index.global.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.15/timegrid.min.css" />
    <link rel="stylesheet" href="../assets/styles/calendar.css">
</head>

<body>
    <main>
        <section>
            <?php if ($campsite): ?>
                <h1><?= htmlspecialchars($campsite['name']); ?></h1>
                <div class="calendar-info" data-price-per-night="<?= htmlspecialchars($campsite['price_per_night']); ?>">
                    <img src="../<?= htmlspecialchars($campsite['image']); ?>" alt="Photo de <?= htmlspecialchars($campsite['name']); ?>" class="calendar-img">
                </div>
            <?php else: ?>
                <p class="error">Erreur : Camping introuvable.</p>
            <?php endif; ?>
        </section>

    <div class="calendar-form-container">
        <section class="reservation-section">
        <h2>Réserver ce camping</h2>
            <form action="payment.php" method="POST">
                <div class="date-fields">
                <input type="hidden" name="campsite_id" value="<?= $campsite_id; ?>">
                
                    <div class="date-field">
                        <label for="start_date">Du</label>
                        <input type="text" id="start_date" name="start_date" readonly required>
                    </div>

                    <div class="date-field">
                        <label for="end_date">au</label>
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

            <input type="submit" value="PAYER">
         </form>
        </section>

        <?php if (!empty($message)): ?>
            <div class="reservation-message">
                <p><?= htmlspecialchars($message); ?></p>
            </div>
        <?php endif; ?>

        <section>
                <div id="calendar"></div>
        </section>
    </div>

    </main>

    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.15/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.15/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rrule/2.6.8/rrule.min.js"></script>

    <script src="../assets/javascript/calendar.js"></script>
</body>
</html>
