<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Articles</title>
    <link rel="stylesheet" href="assets/style/admin/manage.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'; ?>
    </header>
    
    <main>
        <section class="data">
            <div>
                <p>Total d'articles enregistrés</p>
                <img src="assets/icon/news.svg" alt="icon news">
                <p><?php echo htmlspecialchars($total_articles); ?></p> <!-- Correction de la variable -->
            </div>

            <div>
                <p>Dernier article ajouté</p>
                <img src="assets/icon/news.svg" alt="icon news">
                <div>
                    <?php 
                    if (!empty($articles)) { // Changer $campsites en $articles
                        // Sélectionner un article au hasard
                        $randomKey = array_rand($articles);
                        $randomArticle = $articles[$randomKey];

                        // Afficher les informations de l'article choisi
                        echo '<p>' . htmlspecialchars($randomArticle['title']) . '</p>'; // Changer 'name' en 'title'
                    } else {
                        echo '<p>Aucun article disponible pour le moment.</p>';
                    }
                    ?>
                </div>
            </div>

            <div>
                <a href="create_articles">Ajouter un article</a>
                <a href="create_articles"><img src="assets/icon/add.svg" alt="icon add"></a>
            </div>
        </section>

        <section class="board">
            <table>
                <thead>
                    <tr>
                        <td>Titre</td>
                        <td>Date de publication</td>
                        <td>Heure de publication</td>
                        <td>Éditer</td>
                        <td>Supprimer</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?> <!-- Changer $campsites en $articles -->
                        <tr>
                            <td><?php echo htmlspecialchars($article['title']); ?></td> <!-- Changer 'name' en 'title' -->
                            <td><?php echo htmlspecialchars($article['published_date']); ?></td> <!-- Corriger la date -->
                            <td><?php echo htmlspecialchars($article['published_time']); ?></td> <!-- Corriger l'heure -->
                            <td>
                                <form method="GET" action="create_articles"> <!-- Changer l'action pour articles -->
                                    <input type="hidden" name="id" value="<?php echo $article['id']; ?>"> <!-- Utiliser 'id' -->
                                    <button class="edit-button" type="submit"><img src="assets/icon/edit.svg" alt="icon edit"></button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="manage_article" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');"> <!-- Changer l'action pour articles -->
                                    <input type="hidden" name="id" value="<?php echo $article['id']; ?>"> <!-- Utiliser 'id' -->
                                    <button class="del-button" type="submit"><img src="assets/icon/delete.svg" alt="icon delete"></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
