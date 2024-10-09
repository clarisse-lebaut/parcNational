<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Membership Form</title>
        <link rel="stylesheet" href="assets/style/admin/admin-M-form.css">
</head>
<body>

    <h1><?= isset($membership) ? 'Edit Membership' : "Ajout d'une nouvelle adhésion"?></h1>

    <form method="post" action="<?= isset($membership) ? 'admin-memberships-edit' : 'admin-memberships-add' ?>">

        <div class="form">
            <label for="memberships_name">Nom de l'adhésion:</label>
            <input type="text" name="memberships_name" value="<?= isset($membership) ? $membership['memberships_name'] : '' ?>" required>

            <label for="duration">Durée (Mois):</label>
            <input type="number" name="duration" value="<?= isset($membership) ? $membership['duration'] : '' ?>" required>
            
            <label for="price">Prix (€):</label>
            <input type="number" step="0.01" name="price" value="<?= isset($membership) ? $membership['price'] : '' ?>" required>
            
            <?php if (isset($membership)): ?>
                <input type="hidden" name="card_id" value="<?= $membership['card_id'] ?>">
            <?php endif; ?>

            <button type="submit"><?= isset($membership) ? 'Update Membership' : "Ajout d'Adhérent" ?></button>
        </div>
    </form>
</body>
</html>

