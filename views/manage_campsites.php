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
                <p>Total de campings enregistrer</p>
                <img src="assets/icon/campsites.svg" alt="icon campiste">
                <div><?php echo htmlspecialchars($total_campsites); ?></div>
            </div>

            <div>
                <p>Dernier camping ajouter</p>
                <img src="assets/icon/campsite.svg" alt="icon trails">
                <div><?php echo htmlspecialchars($name_campsites); ?></div>
            </div>

            <div>
                <a href="add">Ajouter un camping</a>
                <img src="assets/icon/add.svg" alt="icon visitors">
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