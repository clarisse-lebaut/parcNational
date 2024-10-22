<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Membership Form</title>
        <link rel="stylesheet" href="assets/style/admin/admin-M-form.css">
        <link rel="stylesheet" href="assets/style/admin/create.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'; ?>
    </header>

    <main>
        <p>Crée un nouvel abonnement</p>

        <form method="post" action="<?= isset($membership) ? 'admin-memberships-edit' : 'admin-memberships-add' ?>">

            <section>
                <div>
                    <label for="memberships_name">Nom de l'abonnement</label>
                    <input type="text" name="memberships_name" value="<?= isset($membership) ? $membership['memberships_name'] : '' ?>" required>
                </div>

                <div>
                    <label for="duration">Durée (Mois)</label>
                    <input type="number" name="duration" value="<?= isset($membership) ? $membership['duration'] : '' ?>" required>
                
                    <label for="price">Prix (€)</label>
                    <input type="number" step="0.01" name="price" value="<?= isset($membership) ? $membership['price'] : '' ?>" required>
                    <?php if (isset($membership)): ?>
                        <input type="hidden" name="card_id" value="<?= $membership['card_id'] ?>">
                    <?php endif; ?>
                </div>
            </section>
            
            <section>
                <button type="submit">Ajouter un nouvel abonnement</button>
            </section>
        </form>
    </main>
</body>
</html>

