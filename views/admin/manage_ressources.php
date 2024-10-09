<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Ressources</title>
    <link rel="stylesheet" href="assets/style/admin/manage.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'; ?>
    </header>
    <main>
        <section class="data">
            <div>
                <p>Total de ressources naturelles enregistrées</p>
                <img src="assets/icon/ressources.svg" alt="icon resources">
                <div><?php echo htmlspecialchars($total_ressources); ?></div>
            </div>

            <div>
                <p>Dernière ressource naturelle ajoutée</p>
                <img src="assets/icon/ressource.svg" alt="icon resources">
                <div>
                    <?php 
                    if (!empty($ressources)) {
                        // Sélectionner une ressource au hasard
                        $randomKey = array_rand($ressources); // Obtenir une clé aléatoire du tableau
                        $randomRessource = $ressources[$randomKey]; // Récupérer la ressource correspondante à cette clé

                        // Afficher les informations de la ressource choisie
                        echo '<p>' . htmlspecialchars($randomRessource['name']) . '</p>';
                    } else {
                        echo '<p>Aucune ressource disponible pour le moment.</p>';
                    }
                    ?>
                </div>
            </div>

            <div>
                <a href="create_ressources">Ajouter une ressource naturelle</a>
                <img src="assets/icon/add.svg" alt="icon add">
            </div>    
        </section>

        <section class="board">
            <table>
                <thead>
                    <tr>
                        <td>Nom</td>
                        <td>Type de ressource</td>
                        <td>Localisation</td>
                        <td>Éditer</td>
                        <td>Supprimer</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ressources as $ressource): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ressource['name']); ?></td>
                            <td><?php echo htmlspecialchars($ressource['type']); ?></td>
                            <td><?php echo htmlspecialchars($ressource['location']); ?></td>
                            <td>
                                <form method="GET" action="create_ressources">
                                    <input type="hidden" name="ressource_id" value="<?php echo htmlspecialchars($ressource['ressource_id']); ?>">    
                                    <button type="submit"><img src="assets/icon/edit.svg" alt="icon edit"></button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="manage_ressources" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette ressource ?');">
                                    <input type="hidden" name="ressource_id" value="<?php echo htmlspecialchars($ressource['ressource_id']); ?>">    
                                    <button type="submit"><img src="assets/icon/delete.svg" alt="icon delete"></button>
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
