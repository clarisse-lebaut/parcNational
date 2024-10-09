<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Abonnements</title>
    <link rel="stylesheet" href="assets/style/modify-admin.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'?>
    </header>
    <h2>Gérer les Abonnements</h2>
    <a class="lien-ajout" href="admin-memberships-add">
        Ajouter un Nouvel Abonnement
        <img src="assets/icon/add.svg" alt="icon add">
    </a>
    <section class="board">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>ID</th>
                    <th>Durée (Mois)</th>
                    <th>Prix (€)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($memberships)): ?>
                <?php foreach ($memberships as $membership): ?>
                    <tr>
                        <td><?= htmlspecialchars($membership['memberships_name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($membership['card_id']) ?></td>
                        <td><?= htmlspecialchars($membership['duration']) ?></td>
                        <td><?= htmlspecialchars($membership['price']) ?></td>
                        <td>
                            <a href="admin-memberships-edit?id=<?= htmlspecialchars($membership['card_id']) ?>">
                                <button>
                                    <img src="assets/icon/edit.svg" alt="icon edit">
                                </button>
                            </a>
                            <a href="admin-memberships-delete?id=<?= htmlspecialchars($membership['card_id']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet adhésion?')">
                                <button>
                                    <img src="assets/icon/delete.svg" alt="icon delete">
                                </button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Pas d'abonnement disponible.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
    <nav>
        <ul>
            <li><a class="lien" href="admin-active-memberships-list">Les adhésions actives</a></li>
        </ul>
    </nav>
</body>
</html>
