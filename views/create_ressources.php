<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Ressources</title>
    <link rel="stylesheet" href="assets/style/admin/manage.css">
    <link rel="stylesheet" href="assets/style/admin/create.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'; ?>
    </header>
    <main>
        <p><?php echo $isEdit ? 'Modifier une ressource' : 'Enregistrer une nouvelle ressource'; ?></p>
        <section>
            <form action="" method="POST" enctype="multipart/form-data">
                <!-- Si c'est en mode édition, on ajoute un champ caché pour l'ID de la ressource -->
                <?php if ($isEdit && isset($ressourceData['ressource_id'])): ?>
                    <input type="hidden" name="ressource_id" value="<?php echo htmlspecialchars($ressourceData['ressource_id']); ?>">
                <?php endif; ?>

                <section>
                    <div>
                        <p>Informations générales</p>
                        <!-- Champ : Nom de la ressource -->
                        <label for="name">Nom de la ressource</label>
                        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($ressourceData['name'] ?? ''); ?>" required>

                        <!-- Champ : Description -->
                        <label for="description">Description</label>
                        <textarea name="description" id="description" required><?php echo htmlspecialchars($ressourceData['description'] ?? ''); ?></textarea>

                        <!-- Champ : Localisation -->
                        <label for="location">Localisation</label>
                        <input type="text" name="location" id="location" value="<?php echo htmlspecialchars($ressourceData['location'] ?? ''); ?>" required>
                    </div>

                    <div>
                        <p>Détails de la ressoures</p>
                        <!-- Champ : Type de ressource -->
                        <label for="type">Type de ressource</label>
                        <input type="text" name="type" id="type" value="<?php echo htmlspecialchars($ressourceData['type'] ?? ''); ?>" required>

                        <!-- Champ : Floraison -->
                        <label for="floraison">Floraison</label>
                        <input type="text" name="floraison" id="floraison" value="<?php echo htmlspecialchars($ressourceData['floraison'] ?? ''); ?>" required>

                        <!-- Champ : Image -->
                        <label for="image">Image</label>
                        <input class="img_input" type="file" name="image" id="image" accept="image/png, image/jpeg">
                    </div>

                    <div>
                        <p>Statut de la resssource</p>
                        <!-- Champ : Niveau -->
                        <label for="level">Niveau</label>
                        <input type="text" name="level" id="level" value="<?php echo htmlspecialchars($ressourceData['level'] ?? ''); ?>" required>
        
                        <!-- Champ : Précaution -->
                        <label for="precaution">Précaution</label>
                        <textarea name="precaution" id="precaution"><?php echo htmlspecialchars($ressourceData['precaution'] ?? ''); ?></textarea>
                    </div>
                </section>

                <section>
                    <!-- Bouton de soumission -->
                    <button type="submit"><?php echo $isEdit ? 'Modifier la ressource' : 'Enregistrer la ressource'; ?></button>
                </section>
            </form>
        </section>        
    </main>
</body>
</html>
