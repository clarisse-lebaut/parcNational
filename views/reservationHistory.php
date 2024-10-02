<?php
require_once __DIR__ . '/../models/ReservationModel.php';
require_once __DIR__ . '/../models/CampsiteModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

$campsite_id = isset($_GET['campsite_id']) ? intval($_GET['campsite_id']) : 0;
$status = isset($_GET['status']) ? $_GET['status'] : ''; // Récupérer le statut du paiement
$message = '';
$user_id = 1;

$reservationModel = new ReservationModel();
$campsiteModel = new CampsiteModel();

// si paiement reussi; statut "confirmé"
if ($status === 'success' && isset($_SESSION['reservation_id'])) {
    $reservation_id = $_SESSION['reservation_id'];
    $reservationModel->updateReservationStatus($reservation_id, "confirmée");
    unset($_SESSION['reservation_id']); // Nettoyage de la session après confirmation

    $reservation = $reservationModel->getReservationById($reservation_id);
    $message = "Paiement réussi ! Votre réservation a été confirmée.";
    $recap = [
        'Camping' => $reservation['campsite_name'],
        'Date de début' => $reservation['start_date'],
        'Date de fin' => $reservation['end_date'],
        'Nombre de personnes' => $reservation['num_persons'],
        'Prix total' => $reservation['price']
    ];
} elseif ($status === 'cancel') {
    $message = "Le paiement a été annulé. Vous pouvez réessayer.";
}

// Récupérer l'historique des réservations
$reservations = $reservationModel->getReservationsByUser($user_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Réservations</title>
</head>
<body>
    <main>
        <section>
            <h1>Historique des Réservations</h1>
            <p><?= htmlspecialchars($message); ?></p>

            <?php if (isset($recap)): ?>
                <h2>Récapitulatif de la commande confirmée</h2>
                <ul>
                    <?php foreach ($recap as $key => $value): ?>
                        <li><strong><?= htmlspecialchars($key); ?>:</strong> 
                            <?= isset($value) ? htmlspecialchars($value) : 'Non disponible'; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <h2>Vos réservations</h2>

            <?php if (!empty($reservations)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Camping</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Prix</th>
                            <th>Date de réservation</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $reservation): ?>
                            <tr>
                                <td><?= isset($reservation['campsite_name']) ? htmlspecialchars($reservation['campsite_name']) : 'Non disponible'; ?></td>
                                <td><?= isset($reservation['start_date']) ? htmlspecialchars($reservation['start_date']) : 'Non disponible'; ?></td>
                                <td><?= isset($reservation['end_date']) ? htmlspecialchars($reservation['end_date']) : 'Non disponible'; ?></td>
                                <td><?= isset($reservation['price']) ? htmlspecialchars($reservation['price']) : 'Non disponible'; ?> €</td>
                                <td><?= isset($reservation['reservation_date']) ? htmlspecialchars($reservation['reservation_date']) : 'Non disponible'; ?></td>
                                <td><?= isset($reservation['status']) ? htmlspecialchars($reservation['status']) : 'Non disponible'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune réservation trouvée.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
