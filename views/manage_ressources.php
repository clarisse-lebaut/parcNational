<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Sentiers</title>
    <link rel="stylesheet" href="assets/style/manage.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'?>
    </header>
    <main>
        <section class="data">
            <div>
                <p>Total de ressources naturel enregistrer</p>
                <img src="assets/icon/ressources.svg" alt="icon hiking">
                <div><?php echo htmlspecialchars($total_ressources); ?></div>
            </div>

            <div>
                <p>Dernieère ressources naturel ajouter</p>
                <img src="assets/icon/ressource.svg" alt="icon trails">
                <div><?php echo htmlspecialchars($name_ressources); ?></div>
            </div>

            <div>
                <a href="add">Ajouter une ressources naturel</a>
                <img src="assets/icon/add.svg" alt="icon visitors">
            </div>    
        </section>

        <section class="board">
            <table>
                <thead>
                    <tr>
                        <td>Nom</td>
                        <td>Type de ressources</td>
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
                            <td><button><img src="assets/icon/edit.svg" alt="icon edit"></button></td>
                            <td><button><img src="assets/icon/delete.svg" alt="icon delete"></button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        
    </main>
</body>
</html>