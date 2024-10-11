<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Abonnements</title>
    <link rel="stylesheet" href="assets/style/config/_global-admin.css">
    <link rel="stylesheet" href="assets/style/admin/manage.css">
    <link rel="stylesheet" href="assets/style/admin/modify-admin.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'; ?>
    </header>
    
    
    <section class="data">
        <div>
            <p>Total d'abonnements</p>
            <img src="assets/icon/ships.svg" alt="icon ships">
            <p><?= htmlspecialchars($totalMemberships ?? 0) ?></p> <!-- Affichage du nombre total d'abonnements -->
        </div>

        <div>
            <p>Dernière formule ajouté</p>
            <img src="assets/icon/card_membership.svg" alt="icon ships">
            <p>
                <?php if (!empty($randomMembership)): ?>
                    <?= htmlspecialchars($randomMembership['memberships_name']) ?>
                <?php else: ?>
                    <p>Aucun abonnés</p>
                <?php endif; ?>
            </p>
        </div>

        <div>
            <p>Total d'abonné</p>
            <img src="assets/icon/loyalty.svg" alt="icon users">
            <p><?= htmlspecialchars($totalMemberships ?? 0) ?></p> <!-- Affichage du nombre total d'abonnements -->
        </div>

        <div>
            <a href="admin-active-memberships-list">Liste des abonnées</a>
            <img src="assets/icon/users.svg" alt="icon users">
        </div>

        <div>
            <a href="admin-memberships-add">Ajouter un abonnement</a>
            <img src="assets/icon/add.svg" alt="icon add">
        </div>    
    </section>

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
                                <button class="edit-button">
                                    <img src="assets/icon/edit.svg" alt="icon edit">
                                </button>
                            </a>
                            <a href="admin-memberships-delete?id=<?= htmlspecialchars($membership['card_id']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet adhésion?')">
                                <button class="del-button">
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
</body>
</html>
