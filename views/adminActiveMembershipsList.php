<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Abonnements Actifs</title>
    <link rel="stylesheet" href="assets/style/active-memberships.css">
</head>
<body>
    <h1>Liste des Abonnements Actifs</h1>

    <section class="board">
        <table>
            <thead>
                <tr>
                    <th>Nom d'utilisateur</th>
                    <th>Email</th>
                    <th>Abonnement</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activeMemberships as $membership): ?>
                    <tr>
                        <td><?= htmlspecialchars($membership['user_name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($membership['user_email'] ?? '') ?></td>
                        <td><?= htmlspecialchars($membership['membership_name']?? '') ?></td>
                        <td><?= htmlspecialchars($membership['delivery_date']) ?></td>
                        <td><?= htmlspecialchars($membership['expiry_date']) ?></td>
                        <td><?= htmlspecialchars($membership['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>
</html>
