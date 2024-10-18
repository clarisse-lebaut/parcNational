<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isEdit ? 'Modifier un sentier' : 'Créer un nouveau sentier'; ?></title>
    <link rel="stylesheet" href="assets/style/admin/create.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'; ?>
    </header>
    <main>
        <p><?php echo $isEdit ? 'Modifier le sentier' : 'Créer un nouveau sentier'; ?></p>

        <section class="create_map_container">
                <form action="" method="POST" enctype="multipart/form-data">
                    <!-- Champ caché pour l'ID du sentier si en mode édition -->
                    <?php if ($isEdit && isset($trailData['trail_id'])): ?>
                        <input type="hidden" name="trail_id" value="<?php echo htmlspecialchars($trailData['trail_id']); ?>">
                    <?php endif; ?>

                    <section>
                        <div>
                            <p>Information général</p>
                            <!-- Champ : Nom du sentier -->
                            <label for="name">Nom du sentier</label>
                            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($trailData['name'] ?? ''); ?>" required>

                            <!-- Champ : Information -->
                            <label for="description">Information</label>
                            <input type="text" name="description" id="description" value="<?php echo htmlspecialchars($trailData['description'] ?? ''); ?>" required>
                        
                            <!-- Champ : Image -->
                            <label for="image">Image</label>
                            <input class="img_input" type="file" name="image" id="image" accept="image/png, image/jpeg">
                        </div>
                        
                        <div>
                            <p>Conditions du sentier</p>
                            <!-- Champ : Accès -->
                            <label for="location">Accès</label>
                            <input type="text" name="location" id="location" value="<?php echo htmlspecialchars($trailData['location'] ?? ''); ?>" required>

                            <!-- Champ : Distance en Km -->
                            <label for="distance">Distance (Km)</label>
                            <input type="number" name="distance" id="distance" value="<?php echo htmlspecialchars($trailData['distance'] ?? ''); ?>" min="0" step="0.01" required>

                            <!-- Champ : Temps estimé -->
                            <label for="time">Temps estimé (HH:MM)</label>
                            <input type="text" name="time" id="time" value="<?php echo htmlspecialchars($trailData['time'] ?? ''); ?>">

                    </div>
                    <div>
                        <p>Status</p>
                            <!-- Champ : Difficulté -->
                            <label for="difficulty">Difficulté</label>
                            <select name="difficulty" id="difficulty" required>
                                <option value="">Choisir une difficulté</option>
                                <option value="Facile" <?php echo (isset($trailData['difficulty']) && $trailData['difficulty'] == 'Facile') ? 'selected' : ''; ?>>Facile</option>
                                <option value="Moyen" <?php echo (isset($trailData['difficulty']) && $trailData['difficulty'] == 'Moyen') ? 'selected' : ''; ?>>Moyen</option>
                                <option value="Difficile" <?php echo (isset($trailData['difficulty']) && $trailData['difficulty'] == 'Difficile') ? 'selected' : ''; ?>>Difficile</option>
                            </select>

                            <!-- Champ : État (Ouvert/Fermé) -->
                            <label for="status">État</label>
                            <select name="status" id="status" required>
                                <option value="Ouvert" <?php echo (isset($trailData['status']) && $trailData['status'] == 'Ouvert') ? 'selected' : ''; ?>>Ouvert</option>
                                <option value="Fermé" <?php echo (isset($trailData['status']) && $trailData['status'] == 'Fermé') ? 'selected' : ''; ?>>Fermé</option>
                            </select>
                        </div>
                    </section>

                    <section>
                        <!-- Bouton de soumission -->
                        <button type="submit"><?php echo $isEdit ? 'Modifier le sentier' : 'Créer le sentier'; ?></button>
                    </section>
                </form>

                <!-- Section pour afficher les messages d'erreur ou de succès -->
                <div id="message-container">
                    <?php if (isset($successMessage)): ?>
                        <p class="success"><?php echo htmlspecialchars($successMessage); ?></p>
                    <?php endif; ?>
                    <?php if (isset($errorMessage)): ?>
                        <p class="error"><?php echo htmlspecialchars($errorMessage); ?></p>
                    <?php endif; ?>
                </div>  
        </section>
    </main>
</body>
</html>
