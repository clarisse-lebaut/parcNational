<?php
require_once __DIR__ . '/../models/ReservationModel.php';
require_once __DIR__ . '/../models/CampsiteModel.php';

session_start();

$campsite_id = isset($_GET['campsite_id']) ? intval($_GET['campsite_id']) : 0;
$status = isset($_GET['status']) ? $_GET['status'] : ''; // Récupérer le statut du paiement
$message = '';
$user_id = 1; // À remplacer par l'ID réel de l'utilisateur

$reservationModel = new ReservationModel();
$campsiteModel = new CampsiteModel();

// Si le paiement est un succès, ajouter la réservation
if ($status === 'success' && !isset($_SESSION['reservation_added'])) {
    $start_date = isset($_SESSION['start_date']) ? $_SESSION['start_date'] : '';
    $end_date = isset($_SESSION['end_date']) ? $_SESSION['end_date'] : '';
    $price = isset($_SESSION['price']) ? $_SESSION['price'] : 0;
    $num_persons = isset($_SESSION['num_persons']) ? $_SESSION['num_persons'] : 0;

    // Récupérer les informations du camping
    $campsite = $campsiteModel->getCampsiteById($campsite_id);
    $campsite_name = $campsite ? $campsite['name'] : 'Nom du camping inconnu';

    if ($start_date && $end_date && $price > 0) {
        if ($reservationModel->createReservation($user_id, $campsite_id, $start_date, $end_date, $price)) {
            // Marquer la réservation comme ajoutée pour éviter la duplication
            $_SESSION['reservation_added'] = true;
            $message = "Paiement réussi ! Votre réservation a été confirmée.";
            $recap = [
                'Camping' => $campsite_name, // Ajout du nom du camping
                'Date de début' => $start_date,
                'Date de fin' => $end_date,
                'Nombre de personnes' => $num_persons,
                'Prix total' => $price
            ];

            // Redirection après ajout pour éviter les doublons
            header('Location: reservationHistory.php?status=confirmed');
            exit(); // Assurez-vous que la redirection se fait bien
        } else {
            $message = "Erreur lors de l'ajout de la réservation.";
        }
    } else {
        $message = "Erreur : Informations de réservation manquantes.";
} 
} elseif ($status === 'cancel') {
    $message = "Le paiement a été annulé. Vous pouvez réessayer.";
} elseif ($status === 'confirmed') {
    $message = "Votre réservation a été confirmée et enregistrée.";
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
                <h2>Récapitulatif de la commande</h2>
                <ul>
                    <?php foreach ($recap as $key => $value): ?>
                        <li><strong><?= htmlspecialchars($key); ?>:</strong> <?= htmlspecialchars($value); ?></li>
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
                                <td><?= htmlspecialchars($reservation['campsite_name']); ?></td>
                                <td><?= htmlspecialchars($reservation['start_date']); ?></td>
                                <td><?= htmlspecialchars($reservation['end_date']); ?></td>
                                <td><?= htmlspecialchars($reservation['price']); ?> €</td>
                                <td><?= htmlspecialchars($reservation['reservation_date']); ?></td>
                                <td><?= htmlspecialchars($reservation['status']); ?></td>
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
