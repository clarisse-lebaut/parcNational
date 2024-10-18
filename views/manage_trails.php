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
        <?php include 'components/_header-admin.php'?>
    </header>

    <main>
        
        <section class="data">
            <div>
                <p>Total de sentier enregistrer</p>
                <img src="assets/icon/hiking.svg" alt="icon hiking">
                <p><?php echo htmlspecialchars($total_trails); ?></p>
            </div>

            <div>
                <p>Dernier sentier ajouter</p>
                <img src="assets/icon/trails.svg" alt="icon trails">
                <p><?php echo htmlspecialchars($name_trail); ?></p>
            </div>

            <div>
                <a href="create_trails">Ajouter un sentier</a>
                <a href="create_trails"><img src="assets/icon/add.svg" alt="icon add"></a>
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
                            <td>
                                <form method="GET" action="create_trails">
                                    <input type="hidden" name="trail_id" value="<?php echo htmlspecialchars($trail['trail_id']); ?>">    
                                    <button class="edit-button" type="submit"><img src="assets/icon/edit.svg" alt="icon edit"></button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="manage_trails" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rapport ?');">
                                    <input type="hidden" name="trail_id" value="<?php echo htmlspecialchars($trail['trail_id']); ?>">
                                    <button class="del-button" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce sentier ?');"><img src="assets/icon/delete.svg" alt="icon delete"></button>                                   
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