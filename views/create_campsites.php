<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Sentiers</title>
    <link rel="stylesheet" href="assets/style/admin/manage.css">
    <link rel="stylesheet" href="assets/style/admin/create.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php' ?>
    </header>
    <main>
        <p><?php echo $isEdit ? 'Modifier un camping' : 'Enregistrer un nouveau camping'; ?></p>
        <section>
            <form action="" method="POST" enctype="multipart/form-data">
                <!-- Si c'est en mode édition, on ajoute un champ caché pour l'ID du camping -->
                <?php if ($isEdit && isset($campsiteData['campsite_id'])): ?>
                    <input type="hidden" name="campsite_id" value="<?php echo htmlspecialchars($campsiteData['campsite_id']); ?>">
                <?php endif; ?>
                <section>
                    <div>
                        <p>Informations générales</p>
                        <!-- Champ : Nom du camping -->
                        <label for="name">Nom du camping</label>
                        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($campsiteData['name'] ?? ''); ?>" required>

                        <!-- Champ : Description -->
                        <label for="description">Description</label>
                        <textarea name="description" id="description" required><?php echo htmlspecialchars($campsiteData['description'] ?? ''); ?></textarea>
                    </div>

                    <div>
                        <p>Détails du Camping</p>
                        <!-- Champ : Adresse -->
                        <label for="address">Adresse</label>
                        <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($campsiteData['address'] ?? ''); ?>" required>

                        <!-- Champ : Ville -->
                        <label for="city">Ville</label>
                        <input type="text" name="city" id="city" value="<?php echo htmlspecialchars($campsiteData['city'] ?? ''); ?>" required>

                        <!-- Champ : Code Postal -->
                        <label for="zipcode">Code Postal</label>
                        <input type="number" name="zipcode" id="zipcode" value="<?php echo htmlspecialchars($campsiteData['zipcode'] ?? ''); ?>" required>
                    </div>

                    <div>
                        <p>Satut du camping</p>
                        <!-- Champ : Capacité maximale -->
                        <label for="max_capacity">Capacité maximale</label>
                        <input type="number" name="max_capacity" id="max_capacity" value="<?php echo htmlspecialchars($campsiteData['max_capacity'] ?? ''); ?>" required>

                        <!-- Champ : Image -->
                        <label for="image">Image</label>
                        <input class="img_input" type="file" name="image" id="image" accept="image/png, image/jpeg">

                        <!-- Champ : État (Ouvert/Fermé) -->
                        <label for="status">État</label>
                        <select name="status" id="status" required>
                            <option value="Ouvert" <?php echo (isset($campsiteData['status']) && $campsiteData['status'] == 'Ouvert') ? 'selected' : ''; ?>>Ouvert</option>
                            <option value="Fermé" <?php echo (isset($campsiteData['status']) && $campsiteData['status'] == 'Fermé') ? 'selected' : ''; ?>>Fermé</option>
                        </select>
                    </div>
                </section>

                <section>
                    <!-- Bouton de soumission -->
                    <button type="submit"><?php echo $isEdit ? 'Modifier le camping' : 'Enregistrer le camping'; ?></button>
                </section>
            </form>
        </section>        
    </main>
</body>
</html>
