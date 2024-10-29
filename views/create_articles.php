<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Articles</title>
    <link rel="stylesheet" href="assets/style/admin/manage.css">
    <link rel="stylesheet" href="assets/style/admin/create.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'; ?>
    </header>
    <main>
        <h1><?php echo $isEdit ? 'Modifier un article' : 'Créer un nouvel article'; ?></h1>
        <section>
            <form action="" method="POST" enctype="multipart/form-data">
                <!-- Si c'est en mode édition, on ajoute un champ caché pour l'ID de l'article -->
                <?php if ($isEdit && isset($articleData['id'])): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($articleData['id']); ?>">
                <?php endif; ?>
                
                <section>
                    <div>
                        <p>Informations de l'article</p>
                        <!-- Champ : Titre de l'article -->
                        <label for="title">Titre</label>
                        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($articleData['title'] ?? ''); ?>" required>

                        <!-- Champ : Contenu -->
                        <label for="content">Contenu</label>
                        <textarea name="content" id="content" required><?php echo htmlspecialchars($articleData['content'] ?? ''); ?></textarea>
                    </div>

                    <div>
                        <p>Détails de publication</p>
                        <!-- Champ : Date de publication -->
                        <label for="published_date">Date de publication</label>
                        <input type="date" name="published_date" id="published_date" value="<?php echo htmlspecialchars($articleData['published_date'] ?? ''); ?>" required>

                        <!-- Champ : Heure de publication -->
                        <label for="published_time">Heure de publication</label>
                        <input type="time" name="published_time" id="published_time" value="<?php echo htmlspecialchars($articleData['published_time'] ?? ''); ?>" required>
                    </div>

                    <div>
                        <p>Image de l'article</p>
                        <!-- Champ : Image -->
                        <label for="image">Télécharger une image</label>
                        <input type="file" name="picture" id="image" accept="image/png, image/jpeg" required>
                    </div>
                </section>

                <section>
                    <!-- Bouton de soumission -->
                    <button type="submit"><?php echo $isEdit ? 'Modifier l\'article' : 'Créer l\'article'; ?></button>
                </section>
            </form>
        </section>        
    </main>
</body>
</html>
