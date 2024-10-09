<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isEdit ? 'Modifier un rapport' : 'Créer un nouveau rapport'; ?></title>
    <link rel="stylesheet" href="assets/style/admin/manage.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'; ?>
    </header>
    <main>
        <h1><?php echo $isEdit ? 'Modifier un rapport' : 'Créer un nouveau rapport'; ?></h1>
        <section>
            <form action="" method="POST">
                <!-- Si en mode édition, ajouter un champ caché pour l'ID du rapport -->
                <?php if ($isEdit && isset($reportData['report_id'])): ?>
                    <input type="hidden" name="report_id" value="<?php echo htmlspecialchars($reportData['report_id']); ?>">
                <?php endif; ?>

                <!-- Champ : Nom du rapport -->
                <label for="name">Nom du rapport</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($reportData['name'] ?? ''); ?>" required>

                <!-- Champ : Description -->
                <label for="description">Description</label>
                <textarea name="description" id="description" required><?php echo htmlspecialchars($reportData['description'] ?? ''); ?></textarea>

                <!-- Champ : Ressource associée -->
                <label for="ressource_id">Ressource associée</label>
                <select name="ressource_id" id="ressource_id" required>
                    <option value="">Choisir une ressource</option>
                    <?php foreach ($ressources as $ressource): ?>
                        <option value="<?php echo htmlspecialchars($ressource['ressource_id']); ?>" 
                            <?php if (isset($reportData['ressource_id']) && $reportData['ressource_id'] == $ressource['ressource_id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($ressource['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Bouton de soumission -->
                <button type="submit"><?php echo $isEdit ? 'Modifier le rapport' : 'Enregistrer le rapport'; ?></button>
            </form>
        </section>        
    </main>
</body>
</html>
