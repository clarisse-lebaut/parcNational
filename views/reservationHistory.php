<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations</title>
    <link rel="stylesheet" href="assets/style/reservationHistory.css">
    <link rel="stylesheet" href="assets/style/_global.css">
</head>
<body>
    <header>
        <?php include __DIR__ . '/../components/_header.php'; ?>
    </header>
    
    <main>

    <div class="history-container">
        
        <?php if ($message): ?>
            <p class="history-message"><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <?php if (!empty($recap)): ?>
            <div class="history-recap">
                <h2 class="history-recap-title">Récapitulatif de la dernière réservation</h2>
                <ul class="history-recap-list">
                    <?php foreach ($recap as $key => $value): ?>
                        <li class="history-recap-item"><strong><?= htmlspecialchars($key); ?>:</strong> <?= htmlspecialchars($value); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <h1 class="history-title">Mes réservations</h1>
        
        <?php if (!empty($reservations)): ?>
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Camping</th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th class="price">Prix</th>
                        <th class="date">Date de réservation</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?= htmlspecialchars($reservation['campsite_name'] ?? 'Non disponible'); ?></td>
                            <td><?= htmlspecialchars(date('Y-m-d', strtotime($reservation['start_date'] ?? ''))); ?></td>
                            <td><?= htmlspecialchars(date('Y-m-d', strtotime($reservation['end_date'] ?? ''))); ?></td>
                            <td><?= htmlspecialchars($reservation['price'] ?? 'Non disponible'); ?> €</td>
                            <td><?= htmlspecialchars($reservation['reservation_date'] ?? 'Non disponible'); ?></td>
                            <td class="history-status <?= htmlspecialchars($reservation['status']) ?>"><?= htmlspecialchars($reservation['status'] ?? 'Non disponible'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="history-message">Aucune réservation trouvée.</p>
        <?php endif; ?>
    </main>

    <footer>
        <?php include __DIR__ . '/../components/_footer.php'; ?>
    </footer>
</body>
</html>
