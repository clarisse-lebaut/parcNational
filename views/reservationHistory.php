<?php
require_once __DIR__ . '/../models/ReservationModel.php';
require_once __DIR__ . '/../models/CampsiteModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

$campsite_id = isset($_GET['campsite_id']) ? intval($_GET['campsite_id']) : 0;
$status = isset($_GET['status']) ? $_GET['status'] : '';
$message = '';
$user_id = 1; // user statique pour l'instant

$reservationModel = new ReservationModel();
$campsiteModel = new CampsiteModel();

// Si paiement réussi, statut "confirmé"
if ($status === 'success' && isset($_SESSION['reservation_id'])) {
    $reservation_id = $_SESSION['reservation_id'];
    $reservationModel->updateReservationStatus($reservation_id, "confirmée");
    unset($_SESSION['reservation_id']);

    $reservation = $reservationModel->getReservationById($reservation_id);
    $message = "Paiement réussi ! Votre réservation a été confirmée.";
    $recap = [
        'Camping' => $reservation['campsite_name'],
        'Date de début' => date('Y-m-d', strtotime($reservation['start_date'])), 
        'Date de fin' => date('Y-m-d', strtotime($reservation['end_date'])),     
        'Nombre de personnes' => $reservation['num_persons'],
        'Prix total' => $reservation['price']
    ];
} elseif ($status === 'cancel') {
    $message = "Le paiement a été annulé. Vous pouvez réessayer.";
}

// Annulation de la réservation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_reservation'])) {
    $reservation_id = intval($_POST['reservation_id']);
    
    if ($reservationModel->cancelReservation($reservation_id)) {
        $message = "Réservation annulée avec succès.";
    } else {
        $message = "Impossible d'annuler la réservation. Vous ne pouvez annuler que 7 jours avant la date de début.";
    }
}

// Récupérer l'historique des réservations
$reservations = $reservationModel->getReservationsByUser($user_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations</title>
    <link rel="stylesheet" href="../assets/styles/reservationHistory.css">
    <link rel="stylesheet" href="../assets/styles/_global.css">
</head>
<body>
    <header>
        <?php include __DIR__ . '/../components/_header.php'; ?>
    </header>
    
    <main>
        <section>
            <h1>Mes Réservations</h1>
            <p><?= htmlspecialchars($message); ?></p>

            <?php if (isset($recap)): ?>
                <h2>Récapitulatif de la réservation</h2>
                <ul>
                    <?php foreach ($recap as $key => $value): ?>
                        <li><strong><?= htmlspecialchars($key); ?>:</strong> 
                            <?= isset($value) ? htmlspecialchars($value) : 'Non disponible'; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if (!empty($reservations)): ?>
                <table class="table-history">
                    <thead>
                        <tr>
                            <th>Camping</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Prix</th>
                            <th>Date de réservation</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $reservation): ?>
                            <tr>
                                <td><?= isset($reservation['campsite_name']) ? htmlspecialchars($reservation['campsite_name']) : 'Non disponible'; ?></td>
                                <td><?= isset($reservation['start_date']) ? date('Y-m-d', strtotime($reservation['start_date'])) : 'Non disponible'; ?></td>
                                <td><?= isset($reservation['end_date']) ? date('Y-m-d', strtotime($reservation['end_date'])) : 'Non disponible'; ?></td>
                                <td><?= isset($reservation['price']) ? htmlspecialchars($reservation['price']) : 'Non disponible'; ?> €</td>
                                <td><?= isset($reservation['reservation_date']) ? htmlspecialchars($reservation['reservation_date']) : 'Non disponible'; ?></td>
                                <td><?= isset($reservation['status']) ? htmlspecialchars($reservation['status']) : 'Non disponible'; ?></td>
                                <td>
                                    <?php if ($reservation['status'] !== 'annulée'): ?>
                                        <button type="button" class="cancel-btn" data-reservation-id="<?= $reservation['reservation_id']; ?>">Annuler</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune réservation trouvée.</p>
            <?php endif; ?>
        </section>
    </main>

    <!-- MODALES -->
    <div id="cancel-modal" class="modal">
        <div class="modal-content">
            <p>Êtes-vous sûr de vouloir annuler cette réservation ?</p>
            <button id="confirm-cancel-btn" class="btn-confirm">Oui</button>
            <button id="close-modal-btn" class="btn-close">Non</button>
        </div>
        <div id="error-modal" class="modal">
            <div class="modal-content">
                <p id="error-message"></p>
                <button id="close-error-modal-btn" class="btn-close">Fermer</button>
            </div>
        </div>
    </div>

    <footer>
        <?php include __DIR__ . '/../components/_footer.php'; ?>
    </footer>

    <script src="../assets/javascript/reservationHistory.js"></script>
</body>
</html>
