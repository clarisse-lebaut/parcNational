<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Abonnements Actifs</title>
    <!-- <link rel="stylesheet" href="assets/style/admin/active-memberships.css"> -->
    <link rel="stylesheet" href="assets/style/admin/create.css">
    <link rel="stylesheet" href="assets/style/admin/manage.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'?>
    </header>

    <main>
        <p>Liste des Abonnements Actifs</p>

        <section class="board">
            <table>
                <thead>
                    <tr>
                        <td>Nom d'utilisateur</td>
                        <td>Email</td>
                        <td>Abonnement</td>
                        <td>Date de début</td>
                        <td>Date de fin</td>
                        <td>Status</td>
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
        
    </main>
</body>
</html>
