<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Sentiers</title>
    <link rel="stylesheet" href="assets/style/admin/manage.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php' ?>
    </header>
    <main>
        <section class="data">
            <div>
                <p>Total de campings enregistrés</p>
                <img src="assets/icon/campsites.svg" alt="icon campsite">
                <div><?php echo htmlspecialchars($total_campsites); ?></div>
            </div>

            <div>
                <p>Dernier camping ajouté</p>
                <img src="assets/icon/campsite.svg" alt="icon campsite">
                <div>
                    <?php 
                    if (!empty($campsites)) {
                        // Sélectionner un camping au hasard
                        $randomKey = array_rand($campsites); // Obtenir une clé aléatoire du tableau
                        $randomCampsite = $campsites[$randomKey]; // Récupérer le camping correspondant à cette clé

                        // Afficher les informations du camping choisi
                        echo '<p>' . htmlspecialchars($randomCampsite['name']) . '</p>';
                    } else {
                        echo '<p>Aucun camping disponible pour le moment.</p>';
                    }
                    ?>
                </div>
            </div>

            <div>
                <a href="create_campsite">Ajouter un camping</a>
                <img src="assets/icon/add.svg" alt="icon add">
            </div>    
        </section>

        <section class="board">
            <table>
                <thead>
                    <tr>
                        <td>Nom</td>
                        <td>Ville</td>
                        <td>Adresse</td>
                        <td>Code postal</td>
                        <td>Éditer</td>
                        <td>Supprimer</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($campsites as $campsite): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($campsite['name']); ?></td>
                            <td><?php echo htmlspecialchars($campsite['city']); ?></td>
                            <td><?php echo htmlspecialchars($campsite['address']); ?> km</td>
                            <td><?php echo htmlspecialchars($campsite['zipcode']); ?></td>
                            <td>
                                <form method="GET" action="create_campsite">
                                    <input type="hidden" name="campsite_id" value="<?php echo $campsite['campsite_id']; ?>">    
                                    <button type="submit"><img src="assets/icon/edit.svg" alt="icon edit"></button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="manage_campsite" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce camping ?');">
                                    <input type="hidden" name="campsite_id" value="<?php echo $campsite['campsite_id']; ?>">    
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
