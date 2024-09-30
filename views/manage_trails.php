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
                <p>Total de sentier enregistrer</p>
                <img src="assets/icon/hiking.svg" alt="icon hiking">
                <div><?php echo htmlspecialchars($total_trails); ?></div>
            </div>

            <div>
                <p>Dernier sentier ajouter</p>
                <img src="assets/icon/trails.svg" alt="icon trails">
                <div><?php echo htmlspecialchars($name_trail); ?></div>
            </div>

            <div>
                <a href="create_trails">Ajouter un sentier</a>
                <img src="assets/icon/add.svg" alt="icon visitors">
            </div>    
        </section>

        <section class="board">
            <table>
                <thead>
                    <tr>
                        <td>Nom</td>
                        <td>Difficulté</td>
                        <td>Longueur</td>
                        <td>Temps</td>
                        <td>État</td>
                        <td>Éditer</td>
                        <td>Supprimer</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trails as $trail): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($trail['name']); ?></td>
                            <td><?php echo htmlspecialchars($trail['difficulty']); ?></td>
                            <td><?php echo htmlspecialchars($trail['length_km']); ?> km</td>
                            <td><?php echo htmlspecialchars($trail['time']); ?></td>
                            <td><?php echo htmlspecialchars($trail['status']); ?></td>
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